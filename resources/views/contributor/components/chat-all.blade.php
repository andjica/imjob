<div id="app">
    <chat-component-contributor
        :recruiters='@json($activeConnections ?? [])'
        :current-user-id='@json(auth()->check() ? auth()->user()->id : null)'>
    </chat-component-contributor>
</div>
