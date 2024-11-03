
<tr>
    <td>{{ $request->CourseSession->title ?? 'N/A' }}</td>
    <td>{{ @$request->user->name }}</td>
    <td> {{ __(@$request->type) }}</td>

    <td>
        @php
            // Decode the optional_files if it's stored as JSON
            $files = is_array($request->optional_files) ? $request->optional_files : json_decode($request->optional_files, true);
        @endphp

        @if (!empty($files) && is_array($files))
            @foreach ($files as $file)
                @php
                    $fileUrl = Storage::url($file); // Generate public URL for each file
                    $fileName = basename($file); // Extract file name for display
                @endphp
                <a href="{{ $fileUrl }}" download="{{ $fileName }}">{{ $fileName }}</a><br>
            @endforeach
        @else
            {{ __('No files uploaded') }}
        @endif
    </td>
    <td>
        {{ __(@$request->status) }}
    </td>


<td>
    @if($request->status == "pending")
    <button class="btn btn-secondary"
            data-id="{{ @$request->id }}"
            data-type="{{ @$request->type }}"
            data-status="{{ @$request->status }}"
            data-suggested-dates="{{ json_encode($request->suggested_dates) }}"
            data-bs-toggle="modal"
            data-bs-target="#respondRequestModal"
            id="respondRequestButton">
        <span class="far fa-flag"></span>&nbsp;{{ __('edit')}}
    </button>
    @endif

</td>
</tr>

