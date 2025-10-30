<div class="is-pulled-right mr-6 bs-show-deleted">
    <label class="checkbox">
        <input type="checkbox" class="" id="useSound" value="1" onclick="setUseSound(this)" checked /> Use sound
    </label>
</div>

<script type="text/javascript">

    var playAllSounds = true;
    function playGameSound(sound)
    {
        if (playAllSounds) {
            playAudio(sound);
        }
    }
    function setUseSound(elem)
    {
        playAllSounds = false;
        if ($(elem).is(':checked')) {
            playAllSounds = true;
        }
    }

</script>
