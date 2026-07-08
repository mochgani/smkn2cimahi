<?php

namespace App\Support;

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Ambil event dari Google Calendar API v3 (public calendar, read-only via API key).
 */
class GoogleCalendar
{
    private const CACHE_TTL = 900; // 15 menit

    /**
     * Ambil semua event yang tampil di grid kalender bulan tertentu
     * (termasuk beberapa hari dari bulan sebelum/sesudah yang ikut tampil
     * di grid 6 minggu), sudah dikelompokkan per tanggal (key 'Y-m-d').
     *
     * @return array{events: array, byDate: array<string, array>, error: ?string}
     */
    public static function eventsForMonth(?string $calendarId, int $year, int $month): array
    {
        $apiKey = config('services.google_calendar.api_key');

        if (! $calendarId || ! $apiKey) {
            return ['events' => [], 'byDate' => [], 'error' => null];
        }

        $gridStart = Carbon::create($year, $month, 1)->startOfMonth()->startOfWeek(Carbon::SUNDAY);
        $gridEnd   = Carbon::create($year, $month, 1)->endOfMonth()->endOfWeek(Carbon::SATURDAY);

        $cacheKey = "google_calendar.{$calendarId}.{$year}.{$month}";

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($calendarId, $apiKey, $gridStart, $gridEnd) {
            try {
                $response = Http::timeout(8)->get(
                    'https://www.googleapis.com/calendar/v3/calendars/' . rawurlencode($calendarId) . '/events',
                    [
                        'key'           => $apiKey,
                        'timeMin'       => $gridStart->clone()->startOfDay()->toRfc3339String(),
                        'timeMax'       => $gridEnd->clone()->endOfDay()->toRfc3339String(),
                        'singleEvents'  => 'true',
                        'orderBy'       => 'startTime',
                        'maxResults'    => 250,
                        'timeZone'      => 'Asia/Jakarta',
                    ]
                );

                if (! $response->successful()) {
                    Log::warning('GoogleCalendar: gagal fetch events', ['status' => $response->status()]);
                    return ['events' => [], 'byDate' => [], 'error' => 'Gagal memuat kalender (kemungkinan kalender belum di-set public).'];
                }

                $items = $response->json('items') ?? [];
                $byDate = [];

                $events = collect($items)->map(function (array $item) use (&$byDate) {
                    $isAllDay = isset($item['start']['date']);

                    $start = $isAllDay ? $item['start']['date'] : $item['start']['dateTime'];
                    $end   = $isAllDay ? $item['end']['date']   : ($item['end']['dateTime'] ?? $item['start']['dateTime']);

                    $event = [
                        'id'          => $item['id'],
                        'title'       => $item['summary'] ?? '(Tanpa judul)',
                        'description' => $item['description'] ?? null,
                        'location'    => $item['location'] ?? null,
                        'start'       => $start,
                        'end'         => $end,
                        'all_day'     => $isAllDay,
                        'html_link'   => $item['htmlLink'] ?? null,
                    ];

                    // Kelompokkan event ke setiap tanggal yang dilewatinya.
                    if ($isAllDay) {
                        $cursor  = Carbon::parse($start)->startOfDay();
                        $endDate = Carbon::parse($end)->startOfDay(); // exclusive, sesuai spesifikasi Google
                        while ($cursor->lt($endDate)) {
                            $byDate[$cursor->toDateString()][] = $event;
                            $cursor->addDay();
                        }
                    } else {
                        $dateKey = Carbon::parse($start)->tz('Asia/Jakarta')->toDateString();
                        $byDate[$dateKey][] = $event;
                    }

                    return $event;
                })->values()->all();

                foreach ($byDate as $date => $dayEvents) {
                    usort($dayEvents, fn ($a, $b) => ($a['all_day'] ? '0' : $a['start']) <=> ($b['all_day'] ? '0' : $b['start']));
                    $byDate[$date] = $dayEvents;
                }

                return ['events' => $events, 'byDate' => $byDate, 'error' => null];
            } catch (\Throwable $e) {
                Log::warning('GoogleCalendar: exception saat fetch events', ['message' => $e->getMessage()]);
                return ['events' => [], 'byDate' => [], 'error' => 'Gagal memuat kalender. Silakan coba lagi nanti.'];
            }
        });
    }
}
