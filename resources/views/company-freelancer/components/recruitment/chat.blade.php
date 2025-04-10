<div id="app">
    <chat-component 
        :contributors='@json($contributors)' 
        :candidate='@json($candidate)'
        :currentUserId='@json(auth()->user()->id)'>
    </chat-component>
</div>
