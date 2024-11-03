<div class="row">
    <div class="col-12">
  
    <audio class="player" id="audioPlayer" controls>
                    <source type="audio/mp3">
    </audio>
    </div>
</div>

<script>
    fetch('{{ CourseAudioUrl(@$course->id, @$course_item->file) }}')
        .then(response => response.blob())
        .then(blob => {
            const url = URL.createObjectURL(blob);
            const audio = document.getElementById('audioPlayer');
            audio.src = url;
        });
</script>