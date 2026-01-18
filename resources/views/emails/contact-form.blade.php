<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <title>{{ __('messages.feedback_form.title') }}</title>
    <style>
        body {
            background-color: #f4f7f5;
            font-family: "Segoe UI", Arial, sans-serif;
            color: #1f2937;
            margin: 0;
            padding: 0;
        }
        .wrapper {
            padding: 24px 12px;
        }
        .container {
            max-width: 640px;
            margin: 0 auto;
            padding: 28px;
            background-color: #ffffff;
            border-radius: 16px;
            box-shadow: 0 12px 30px rgba(15, 23, 42, 0.08);
            border: 1px solid #e5e7eb;
        }
        .brand {
            display: inline-block;
            font-size: 12px;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            color: #16a34a;
            font-weight: 700;
        }
        .logo {
            display: inline-block;
            margin-bottom: 12px;
        }
        .logo img {
            height: 36px;
            width: auto;
            display: block;
        }
        h1 {
            margin: 8px 0 20px;
            font-size: 20px;
            font-weight: 700;
            color: #0f172a;
        }
        .info {
            background: #f9fafb;
            border-radius: 12px;
            padding: 16px 18px;
            border: 1px solid #e5e7eb;
        }
        p {
            font-size: 14px;
            line-height: 1.6;
            margin: 8px 0;
        }
        .label {
            font-weight: 700;
            color: #111827;
        }
        .value {
            color: #1f2937;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
            color: #6b7280;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="wrapper">
    <div class="container">
        @php
            $settings = app(\App\Settings\GlobalSettings::class);
            $logoPath = $settings->logo ?? null;
            $logoRelativeUrl = $logoPath ? \Illuminate\Support\Facades\Storage::url($logoPath) : null;
            $logoUrl = $logoRelativeUrl ? url($logoRelativeUrl) : null;
        @endphp
        @if ($logoUrl)
            <div class="logo">
                <img src="{{ $logoUrl }}" alt="{{ config('app.name') }}">
            </div>
        @else
            <div class="brand">{{ config('app.name') }}</div>
        @endif
        <h1>{{ __('messages.feedback_form.email_title') }}</h1>
        <div class="info">
            <p><span class="label">{{ __('messages.feedback_form.name_label') }}:</span> <span class="value">{{ htmlspecialchars($name) }}</span></p>
            <p><span class="label">{{ __('messages.feedback_form.phone_label') }}:</span> <span class="value">{{ htmlspecialchars($phone) }}</span></p>
            <p><span class="label">{{ __('messages.feedback_form.comment_label') }}:</span> <span class="value">{{ htmlspecialchars($formMessage) }}</span></p>
        </div>
        <div class="footer"></div>
    </div>
</div>
</body>
</html>
