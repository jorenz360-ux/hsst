<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Privacy Policy – HSSTian Alumni Association</title>
  <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;800&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet"/>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            royal: { DEFAULT:'#1a3fc4', dark:'#0f2580', frost:'#eef2ff' },
            gold:  { DEFAULT:'#c4960a' },
            ink:   { DEFAULT:'#0d1526', soft:'#2d3a52', muted:'#5a6a85' },
          },
          fontFamily: {
            display: ['"Playfair Display"','Georgia','serif'],
            sans:    ['"Inter"','system-ui','sans-serif'],
          },
        }
      }
    }
  </script>
</head>
<body class="font-sans bg-slate-50 text-ink">

{{-- Nav --}}
<header class="sticky top-0 z-50 bg-white/95 backdrop-blur border-b border-slate-200">
  <div class="max-w-4xl mx-auto px-6 h-14 flex items-center justify-between">
    <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
      <img src="{{ asset('images/hsstlogo.jpg') }}" alt="HSST" class="h-7 w-auto object-contain"/>
      <span class="font-display font-bold text-ink text-sm">HSSTian Alumni</span>
    </a>
    <a href="{{ route('home') }}"
       class="text-xs font-semibold text-royal hover:text-royal-dark flex items-center gap-1 transition-colors">
      <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18"/>
      </svg>
      Back to Home
    </a>
  </div>
</header>

{{-- Hero --}}
<div style="background:linear-gradient(135deg,#0f2580 0%,#1a3fc4 60%,#2952d9 100%);" class="py-14 px-6">
  <div class="max-w-4xl mx-auto">
    <p class="text-xs font-bold uppercase tracking-[.25em] text-white/50 mb-3">Legal</p>
    <h1 class="font-display font-bold text-white" style="font-size:clamp(2rem,5vw,3rem);">Privacy Policy</h1>
    <p class="text-white/60 mt-2 text-sm">HSSTian Alumni Association · Holy Spirit School of Tagbilaran</p>
    <div class="mt-4 inline-flex items-center gap-2 bg-white/10 border border-white/15 rounded-full px-4 py-1.5">
      <svg class="w-3.5 h-3.5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5"/>
      </svg>
      <span class="text-xs font-semibold text-white/70">Effective Date: April 19, 2026</span>
    </div>
  </div>
</div>

{{-- Content --}}
<main class="max-w-4xl mx-auto px-6 py-14">
  <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

    {{-- Intro banner --}}
    <div class="px-8 py-5 border-b border-slate-100" style="background:#eff6ff;">
      <p class="text-sm text-royal leading-relaxed">
        This Privacy Policy explains how the <strong>HSSTian Alumni Association – HSST Reunion 2026</strong> collects, uses, and protects your personal information in compliance with
        <strong>Republic Act No. 10173</strong> (Data Privacy Act of 2012) of the Philippines.
      </p>
    </div>

    <div class="px-8 py-10 space-y-10 text-sm text-ink/80 leading-7">

      {{-- Section helper macro via blade component not needed — just repeat pattern --}}

      <section>
        <h2 class="font-display font-bold text-ink text-xl mb-3 flex items-center gap-2.5">
          <span class="w-7 h-7 rounded-lg bg-royal flex items-center justify-center text-white text-xs font-bold shrink-0">1</span>
          Who We Are
        </h2>
        <p>
          The HSST Reunion 2026 web portal is operated by the <strong>Holy Spirit School of Tagbilaran (HSST) Reunion Committee</strong>,
          located at Holy Spirit School, Tagbilaran City, Bohol 6300, Philippines.
          We are committed to safeguarding your personal information and upholding your rights as a data subject.
        </p>
      </section>

      <section>
        <h2 class="font-display font-bold text-ink text-xl mb-3 flex items-center gap-2.5">
          <span class="w-7 h-7 rounded-lg bg-royal flex items-center justify-center text-white text-xs font-bold shrink-0">2</span>
          Information We Collect
        </h2>
        <p class="mb-3">When you register or use this platform, we may collect the following:</p>
        <ul class="space-y-2 pl-1">
          @foreach ([
            ['icon'=>'person','text'=>'Full name, email address, and mobile number'],
            ['icon'=>'school','text'=>'Batch, graduation year, and educational level'],
            ['icon'=>'work','text'=>'Occupation and home address'],
            ['icon'=>'payment','text'=>'Donation records and event registration fees'],
          ] as $item)
          <li class="flex items-start gap-2.5">
            <span class="mt-1 w-1.5 h-1.5 rounded-full bg-royal/40 shrink-0"></span>
            <span>{{ $item['text'] }}</span>
          </li>
          @endforeach
        </ul>
      </section>

      <section>
        <h2 class="font-display font-bold text-ink text-xl mb-3 flex items-center gap-2.5">
          <span class="w-7 h-7 rounded-lg bg-royal flex items-center justify-center text-white text-xs font-bold shrink-0">3</span>
          How We Use Your Information
        </h2>
        <p class="mb-3">We use your data solely for reunion-related purposes, including:</p>
        <ul class="space-y-2 pl-1">
          @foreach ([
            'Verifying your alumni identity and managing your account',
            'Processing event registrations and donations',
            'Sending event updates, announcements, and reminders',
            'Generating batch-level reports for authorized coordinators',
            'Complying with legal and regulatory requirements',
          ] as $item)
          <li class="flex items-start gap-2.5">
            <span class="mt-1 w-1.5 h-1.5 rounded-full bg-royal/40 shrink-0"></span>
            <span>{{ $item }}</span>
          </li>
          @endforeach
        </ul>
      </section>

      <section>
        <h2 class="font-display font-bold text-ink text-xl mb-3 flex items-center gap-2.5">
          <span class="w-7 h-7 rounded-lg bg-royal flex items-center justify-center text-white text-xs font-bold shrink-0">4</span>
          Who Can Access Your Information
        </h2>
        <div class="grid sm:grid-cols-2 gap-3 mt-2">
          @foreach ([
            ['role'=>'Reunion Coordinators','desc'=>'Full access to manage accounts and generate reports','color'=>'#1a3fc4','bg'=>'#eef2ff'],
            ['role'=>'SSPS Staff','desc'=>'Event and announcement management only','color'=>'#065f46','bg'=>'#ecfdf5'],
            ['role'=>'Batch Representatives','desc'=>'Batch-level member reports only','color'=>'#92400e','bg'=>'#fffbeb'],
            ['role'=>'Other Alumni','desc'=>'Cannot view other members\' personal details','color'=>'#6b7280','bg'=>'#f9fafb'],
          ] as $r)
          <div class="rounded-xl px-4 py-3.5 border" style="background:{{ $r['bg'] }};border-color:{{ $r['color'] }}22;">
            <p class="font-bold text-xs" style="color:{{ $r['color'] }};">{{ $r['role'] }}</p>
            <p class="text-xs mt-1 text-ink/65">{{ $r['desc'] }}</p>
          </div>
          @endforeach
        </div>
        <p class="mt-4">We do <strong>not</strong> sell, trade, or share your personal data with third parties, except as required by law.</p>
      </section>

      <section>
        <h2 class="font-display font-bold text-ink text-xl mb-3 flex items-center gap-2.5">
          <span class="w-7 h-7 rounded-lg bg-royal flex items-center justify-center text-white text-xs font-bold shrink-0">5</span>
          Donations &amp; Fees
        </h2>
        <p>
          Event registration fees and donations are recorded within the platform for reporting and coordination purposes.
          Payment collection details will be communicated by the reunion committee through official channels.
        </p>
      </section>

      <section>
        <h2 class="font-display font-bold text-ink text-xl mb-3 flex items-center gap-2.5">
          <span class="w-7 h-7 rounded-lg bg-royal flex items-center justify-center text-white text-xs font-bold shrink-0">6</span>
          Data Storage &amp; Security
        </h2>
        <p>
          Your data is stored on secure cloud servers. We implement industry-standard measures including hashed passwords,
          encrypted connections (HTTPS), and role-based access controls to protect your information.
        </p>
      </section>

      <section>
        <h2 class="font-display font-bold text-ink text-xl mb-3 flex items-center gap-2.5">
          <span class="w-7 h-7 rounded-lg bg-royal flex items-center justify-center text-white text-xs font-bold shrink-0">7</span>
          Your Rights Under RA 10173
        </h2>
        <p class="mb-3">As a data subject under the Data Privacy Act of 2012, you have the right to:</p>
        <div class="space-y-2">
          @foreach ([
            ['right'=>'Access','desc'=>'Request a copy of the personal data we hold about you'],
            ['right'=>'Correction','desc'=>'Update inaccurate or incomplete data via your profile settings'],
            ['right'=>'Erasure','desc'=>'Request deletion of your account and associated personal data'],
            ['right'=>'Object','desc'=>'Opt out of certain uses of your personal information'],
            ['right'=>'Portability','desc'=>'Receive your data in a structured, commonly used format'],
          ] as $r)
          <div class="flex items-start gap-3 rounded-xl px-4 py-3 bg-slate-50 border border-slate-100">
            <span class="font-bold text-royal text-xs w-20 shrink-0 mt-0.5">{{ $r['right'] }}</span>
            <span class="text-xs text-ink/70">{{ $r['desc'] }}</span>
          </div>
          @endforeach
        </div>
        <p class="mt-4">To exercise any of these rights, please contact us at the email address below.</p>
      </section>

      <section>
        <h2 class="font-display font-bold text-ink text-xl mb-3 flex items-center gap-2.5">
          <span class="w-7 h-7 rounded-lg bg-royal flex items-center justify-center text-white text-xs font-bold shrink-0">8</span>
          Data Retention
        </h2>
        <p>
          We retain your personal data for as long as your account is active or as needed for legitimate reunion-related purposes.
          After the reunion event, data may be archived for historical and association records.
          You may request deletion of your account at any time by contacting us.
        </p>
      </section>

      <section>
        <h2 class="font-display font-bold text-ink text-xl mb-3 flex items-center gap-2.5">
          <span class="w-7 h-7 rounded-lg bg-royal flex items-center justify-center text-white text-xs font-bold shrink-0">9</span>
          Cookies
        </h2>
        <p>
          This website uses session cookies strictly necessary for authentication and security.
          We do not use advertising, tracking, or analytics cookies that share data with third parties.
        </p>
      </section>

      <section>
        <h2 class="font-display font-bold text-ink text-xl mb-3 flex items-center gap-2.5">
          <span class="w-7 h-7 rounded-lg bg-royal flex items-center justify-center text-white text-xs font-bold shrink-0">10</span>
          Contact Us
        </h2>
        <p class="mb-4">For privacy concerns, data requests, or questions about this policy, please reach us at:</p>
        <div class="rounded-2xl border border-slate-200 bg-slate-50 px-6 py-5 flex flex-col sm:flex-row sm:items-center gap-4">
          <div class="w-10 h-10 rounded-xl bg-royal flex items-center justify-center shrink-0">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"/>
            </svg>
          </div>
          <div>
            <p class="text-xs font-bold uppercase tracking-widest text-ink/40 mb-0.5">Email</p>
            <a href="mailto:alumni@hss-tagbilaran.edu.ph" class="font-semibold text-royal hover:underline">
              alumni@hss-tagbilaran.edu.ph
            </a>
          </div>
          <div class="sm:ml-8">
            <p class="text-xs font-bold uppercase tracking-widest text-ink/40 mb-0.5">Address</p>
            <p class="text-sm text-ink/70">Holy Spirit School, Tagbilaran City, Bohol 6300</p>
          </div>
        </div>
      </section>

    </div>

    {{-- Footer note --}}
    <div class="px-8 py-5 border-t border-slate-100 bg-slate-50">
      <p class="text-xs text-ink/40 text-center">
        This policy may be updated periodically. Continued use of the platform after changes constitutes acceptance of the revised policy.
        Last updated: April 19, 2026.
      </p>
    </div>

  </div>
</main>

{{-- Footer --}}
<footer class="border-t border-slate-200 py-6 px-6 text-center">
  <p class="text-xs text-ink/30">
    © {{ now('Asia/Manila')->format('Y') }} HSSTian Alumni Association · Holy Spirit School of Tagbilaran. All rights reserved.
  </p>
  <a href="{{ route('home') }}" class="text-xs text-royal/60 hover:text-royal mt-1 inline-block transition-colors">← Back to Home</a>
</footer>

</body>
</html>
