
@php
$price = $userpack->price;
if($user->country) {
    $price = ceil($user->country->currency_exchange_rate*$price) . ' ' . $user->country->currency_name;
}else {
    $price = $price .' $';
}
@endphp
<tr>
    <td>{{ @$userpack->package->title }}</td>
    <td>{{ @$price }}</td>
    <td>{{ @$userpack->num_hours }}</td>
    <td>
        @php($private_lessons_count = @$userpack->private_lessons->count())
        @if ($private_lessons_count)
            <a href="{{ route('user.private_lessons.index') }}?package_id=3" class="btn btn-primary p-1 px-2">{{ $private_lessons_count }}</a>
        @else
            {{ $private_lessons_count }}
        @endif
    </td>
    <td>{{ @$userpack->num_hours - $private_lessons_count }}</td>
    <td>{{ $created_at = @$userpack->created_at->format('Y-m-d H:i:s') }}</td>
    <td data-id="{{$userpack->id}}">{{ $userpack->package?->num_months ? (new Carbon\Carbon($created_at))->addMonth($userpack->package?->num_months) : '-' }}</td>
</tr>
