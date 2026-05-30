<?php

namespace App\Support;

use Symfony\Component\HtmlSanitizer\HtmlSanitizer as SymfonyHtmlSanitizer;
use Symfony\Component\HtmlSanitizer\HtmlSanitizerConfig;

/**
 * Wrapper untuk Symfony HtmlSanitizer dengan whitelist tag
 * yang aman untuk RichEditor Filament (berita, sambutan, sejarah).
 *
 * Mencegah XSS dengan strip <script>, <iframe>, on* attributes,
 * javascript: URL, dll.
 */
class HtmlSanitizer
{
    private static ?SymfonyHtmlSanitizer $instance = null;

    public static function sanitize(?string $html): string
    {
        if ($html === null || $html === '') {
            return '';
        }

        return self::instance()->sanitize($html);
    }

    private static function instance(): SymfonyHtmlSanitizer
    {
        if (self::$instance !== null) {
            return self::$instance;
        }

        $config = (new HtmlSanitizerConfig())
            // Element teks dasar
            ->allowElement('p')
            ->allowElement('br')
            ->allowElement('hr')
            ->allowElement('strong')
            ->allowElement('em')
            ->allowElement('u')
            ->allowElement('s')
            ->allowElement('mark')
            ->allowElement('sub')
            ->allowElement('sup')

            // Heading
            ->allowElement('h1')
            ->allowElement('h2')
            ->allowElement('h3')
            ->allowElement('h4')
            ->allowElement('h5')
            ->allowElement('h6')

            // List
            ->allowElement('ul')
            ->allowElement('ol')
            ->allowElement('li')

            // Quote
            ->allowElement('blockquote')
            ->allowElement('cite')

            // Inline
            ->allowElement('span')
            ->allowElement('div')

            // Link & image dengan attribute terbatas
            ->allowElement('a', ['href', 'title', 'target', 'rel'])
            ->allowElement('img', ['src', 'alt', 'title', 'width', 'height'])

            // Tabel
            ->allowElement('table')
            ->allowElement('thead')
            ->allowElement('tbody')
            ->allowElement('tr')
            ->allowElement('th')
            ->allowElement('td')

            // Code & preformatted
            ->allowElement('code')
            ->allowElement('pre')

            // Restrict URL scheme — hanya http/https/mailto/tel
            ->allowLinkSchemes(['http', 'https', 'mailto', 'tel'])
            ->allowMediaSchemes(['http', 'https', 'data'])

            // Block javascript: dll otomatis (default Symfony sanitizer)
            ->forceHttpsUrls(false); // jangan force HTTPS image kalau user pakai HTTP

        self::$instance = new SymfonyHtmlSanitizer($config);
        return self::$instance;
    }
}
