@if (count($msgs) > 0)
    <div class="container is-fluid">
        <section class="hero">
            <div class="hero-body">
                <p class="bs-msgs-title">Please review the following message(s)</p>
                <div class="fixed-grid has-1-cols">
                    <div class="grid">
                        @foreach ($msgs as $msgAry)
                            <div class="cell bs-msgs">{{ $msgAry['message_text'] }}</div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </div>
@endif