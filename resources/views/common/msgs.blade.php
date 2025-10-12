@if (count($msgs) > 0)
    <div class="container is-fluid">
        <section class="hero">
            <div class="hero-body">
                <p class="bs-msgs-title">Please review the following message(s)</p>
                <div class="fixed-grid has-1-cols">
                    <div class="grid">
                        @foreach ($msgs as $msgAry)
                            <div class="cell bs-msgs">{{ $msgAry['message_text'] }} <a class="bs-msgs-link" href="javascript: markAsRead('{{ $msgAry['id'] }}')">mark as read</a></div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    </div>
@endif

<script type="text/javascript">
    /**
     * Ajax call to set the message to having been read
     */
    function markAsRead(messageId)
    {
        let messageData = {
            messageId: messageId,
            user_token: getCookie('user_token')
        };
        ajaxCall('markAsRead', JSON.stringify(messageData), handleMessageRead);
    }


    /**
     * Ajax call to set the message to having been read
     */
    function handleMessageRead(returnedMessageCall)
    {
        location.reload();
    }
</script>