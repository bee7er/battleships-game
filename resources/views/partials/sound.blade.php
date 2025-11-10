<div class="is-pulled-right mr-6 bs-show-deleted">
    <label class="checkbox">
        Sound:
        <input type="radio" id="audio_id_1" name="audio" value="1.0" onclick="onClickSelectAudio(this);" checked />
        <label for="audio_id_1">Full</label>
        <input type="radio" id="audio_id_2" name="audio" value="0.75" onclick="onClickSelectAudio(this);" />
        <label for="audio_id_2">75%</label>
        <input type="radio" id="audio_id_3" name="audio" value="0.50" onclick="onClickSelectAudio(this);" />
        <label for="audio_id_3">50%</label>
        <input type="radio" id="audio_id_4" name="audio" value="0.25" onclick="onClickSelectAudio(this);" />
        <label for="audio_id_4">25%</label>
        <input type="radio" id="audio_id_5" name="audio" value="0" onclick="onClickSelectAudio(this);" />
        <label for="audio_id_5">Off</label>
    </label>
</div>

<script type="text/javascript">

    var audioLevel = 1.0;
    function playGameSound(sound)
    {
        if (audioLevel > 0.0) {
            playAudio(sound);
        }
    }
    function onClickSelectAudio(elem)
    {
        audioLevel = $(elem).val();
    }

    /**
     * Check for the issuing of a sound
     */
    function checkForSound(locationStatus)
    {
        if ('hit' == locationStatus) {
            playGameSound('hit');
        } else if ('destroyed' == locationStatus) {
            playGameSound('destroyed');
        }
        // else, no sound
    }

    /**
     * Play audio
     */
    function playAudio(sound)
    {
        let audio = new Audio('sounds/' + sound + '.wav');
        if (audioLevel > 0.0) {
            audio.volume = audioLevel;
            audio.play()
        }
    }

</script>
