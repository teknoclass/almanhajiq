<div class="postion-fixed fixed-social hide-sm">
    <ul class="d-flex flex-column">
        @foreach ($social_media as $social)
            @if ($social->getLink() != '#')
                <li>
                    <a href="{{ $social->getLink() }}" target="_blank">
                        <i class="fa-brands {{ $social->icon }}"> </i>
                    </a>
                </li>
            @endif
        @endforeach
    </ul>
</div>
