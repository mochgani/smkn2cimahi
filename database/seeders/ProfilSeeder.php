<?php

namespace Database\Seeders;

use App\Models\ProfilKepalaSekolah;
use App\Models\ProfilSejarah;
use App\Models\ProfilVisiMisi;
use Illuminate\Database\Seeder;

class ProfilSeeder extends Seeder
{
    public function run(): void
    {
        ProfilSejarah::updateOrCreate(['id' => 1], [
            'title'             => 'Sejarah SMK Negeri 2 Cimahi',
            'lead'              => 'Institusi pendidikan kejuruan yang berkomitmen mencetak lulusan unggul dan siap kerja, terletak di wilayah utara Kota Cimahi, Jawa Barat.',
            'tahun_berdiri'     => '2007',
            'luas_lahan'        => '15.609 m²',
            'video_youtube_url' => null,
            'content'           => <<<HTML
<p>SMK Negeri 2 Cimahi adalah institusi pendidikan kejuruan yang <strong>berkomitmen mencetak lulusan unggul dan siap kerja</strong>. Terletak di wilayah utara Kota Cimahi, Jawa Barat, sekolah ini didirikan pada tahun 2007 dan menempati lahan seluas 15.609 m².</p>
<p>Sejak awal pendirian, institusi ini mengalami perkembangan pesat. Dimulai dengan hanya dua program keahlian, sekolah ini kini menawarkan enam kompetensi unggulan, mencakup Teknik Mekatronika, Desain Komunikasi Visual, Rekayasa Perangkat Lunak, Animasi, Teknik Kimia Industri, dan Teknik Pemesinan.</p>
<p>Sebagai lembaga pendidikan vokasi berbasis industri, institusi ini menjalin kerja sama dengan berbagai perusahaan untuk menyelaraskan kurikulum dengan kebutuhan pasar kerja. Program unggulannya meliputi Kelas Industri BUMA SCHOOL (pertambangan batu bara), Kelas Industri Ayena Studio (animasi profesional), Cimahi Markerspace (kewirausahaan digital), dan Teaching Factory — suatu sistem pembelajaran berbasis produksi dan simulasi lingkungan kerja.</p>
<p>Melalui <em>pendekatan berbasis industri dan inovasi pembelajaran modern</em>, sekolah ini terus berkembang sebagai institusi pilihan bagi peserta didik yang menginginkan pendidikan berkualitas dengan prospek karir yang kompetitif.</p>
HTML,
        ]);

        ProfilVisiMisi::updateOrCreate(['id' => 1], [
            'visi'  => 'Menjadikan Lulusan SMK yang Mampu Berwirausaha, Inovatif di Bidang Teknologi, Religius, Santun, Handal dan Berkarakter Sesuai Budaya Bangsa Sampai Tahun 2029.',
            'misi'  => [
                'Mewujudkan lingkungan sekolah yang religius',
                'Mewujudkan kompetensi kewirausahaan yang mandiri dan kompetitif',
                'Meningkatkan kemitraan dengan IDUKA',
                'Meningkatkan kompetensi siswa sesuai kebutuhan IDUKA',
                'Mewujudkan pembelajaran berbasis produksi/project sesuai dengan kebutuhan IDUKA',
                'Meningkatkan sumber daya manusia melalui sertifikasi IDUKA',
                'Mewujudkan manajemen sekolah yang mengacu pada sistem manajemen mutu',
                'Meningkatkan sarana berstandar IDUKA',
                'Mewujudkan nilai-nilai karakter bangsa',
            ],
            'tujuan' => [
                'Menghasilkan tamatan yang menjunjung tinggi norma agama, berkarakter budaya bangsa serta berbudi pekerti luhur.',
                'Menghasilkan tamatan yang terampil, produktif, kreatif dan mandiri sesuai tuntutan dunia kerja.',
                'Menghasilkan tamatan yang sadar akan lingkungan dan mampu memanfaatkannya secara efektif dan efisien.',
            ],
        ]);

        ProfilKepalaSekolah::updateOrCreate(['id' => 1], [
            'nama'     => 'Kepala Sekolah',
            'jabatan'  => 'Kepala SMK Negeri 2 Cimahi',
            'sambutan' => <<<HTML
<p>Assalamu'alaikum Warahmatullahi Wabarakatuh.</p>
<p>Selamat datang di website resmi SMK Negeri 2 Cimahi. Kami sangat bangga dapat menyambut Anda di institusi pendidikan kejuruan yang berkomitmen mencetak lulusan unggul dan siap kerja.</p>
<p>Sebagai sekolah vokasi berbasis industri, kami terus berupaya menyelaraskan kurikulum dengan kebutuhan dunia kerja melalui kerja sama dengan berbagai perusahaan dan program-program unggulan.</p>
<p>Semoga website ini bermanfaat sebagai jendela informasi seputar SMK Negeri 2 Cimahi.</p>
<p>Wassalamu'alaikum Warahmatullahi Wabarakatuh.</p>
HTML,
        ]);
    }
}
