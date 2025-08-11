<?php
namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use OpenTelemetry\Contrib\Otlp\OtlpHttpTransportFactory;
use OpenTelemetry\Contrib\Otlp\SpanExporter;
use OpenTelemetry\SDK\Trace\SpanExporter\ConsoleSpanExporterFactory;
use OpenTelemetry\SDK\Trace\SpanProcessor\SimpleSpanProcessor;
use OpenTelemetry\SDK\Trace\TracerProvider;

class ShortenerController extends Controller
{
    private $tracer;

    public function __construct()
    {
        $this->tracer = (new TracerProvider(
            new SimpleSpanProcessor(
                new SpanExporter(
                    (new OtlpHttpTransportFactory())->create('http://jaeger:4318/v1/traces', 'application/json')
                )
            )
        ))->getTracer('io.opentelemetry.contrib.php');
    }


    public function index()
    {
        $span = $this->tracer
            ->spanBuilder('GET /')
            ->startSpan();

        $span->addEvent('Fetching latest URLs from DB');

        $urls = Url::latest()->limit(20)->get();

        $span->addEvent('Fetched latest URLs from DB');

        $span->setAttribute("url_count", $urls->count());

        $span->end();

        return view('shortener.index', compact('urls'));
    }

    public function store(Request $request)
    {
        $span = $this->tracer
            ->spanBuilder('POST /store')
            ->startSpan();

        $request->validate(['url' => 'required|url']);

        do {
            $code = Str::random(6);
        } while (Url::where('code', $code)->exists());

        $span->setAttribute('shortened_url_code', $code);

        $span->addEvent('Creating shortened URL On DB');

        Url::create([
            'code' => $code,
            'target_url' => $request->input('url'),
        ]);

        $span->addEvent('Shortened URL created On DB');

        $span->end();

        return redirect()->route('home')->with('success', url("/{$code}"));
    }

    public function redirect($code)
    {
        $span = $this->tracer
            ->spanBuilder('GET /{code}')
            ->startSpan();

        $span->setAttribute('shortened_url_code', $code);

        $span->addEvent('Fetching URL from DB');
        $url = Url::where('code', $code)->firstOrFail();
        $span->addEvent('Fetched URL from DB');

        $url->increment('clicks');
        $span->addEvent('Incremented clicks');

        $span->setAttribute('target_url', $url->target_url);

        $span->end();

        return redirect()->away($url->target_url);
    }
}
