<div id="app">

    <chat-component 
        :contributors='@json($contributors)' 
        :candidate='@json($candidate)'
        :current-user-id='@json(auth()->check() ? auth()->user()->id : null)'>
    </chat-component>

</div>
