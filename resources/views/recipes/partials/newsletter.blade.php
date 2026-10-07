<section class="newsletter" id="newsletter">
    <div class="newsletter-copy">
        <span class="eyebrow">A good thing in your inbox</span>
        <h2>A pinch of inspiration, <span>once a week.</span></h2>
        <p>Fresh recipes, kitchen notes, and little reasons to linger at the table.</p>
    </div>
    <form class="newsletter-form" action="{{ route('newsletter.store') }}" method="POST">
        @csrf
        <label class="visually-hidden" for="newsletter-email">Your email address</label>
        <input id="newsletter-email" name="email" type="email" value="{{ old('email') }}" placeholder="Your email address" required maxlength="255">
        <button class="button button-dark" type="submit">Count me in <span aria-hidden="true">→</span></button>
        <p class="newsletter-feedback" role="status">{{ session('newsletter_status', $errors->first('email') ?: 'No spam. Just the good stuff.') }}</p>
    </form>
</section>
