<tr id="course_row_{{ @$course->id }}">
    <td><span class="d-flex align-items-center"><span class="symbol symbol-40"><img class="rounded-circle" src="{{ asset('assets/front/images/avatar.png') }}" alt="" loading="lazy"/></span><span class="ms-2">{{@$course->title}}</span></span></td>
	<td>{{ @$course->category->name }}</td>
	<td><strong>{!! @$course->getPriceDisc() !!}</strong></td>
</tr>
