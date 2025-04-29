<div id="app">

    <chat-component-recruiter-all 
        :contributors='@json($contributors ?? [])' 
        :candidates='@json($candidates ?? [])'
        :current-user-id='@json(auth()->check() ? auth()->user()->id : null)'>
    </chat-component-recruiter-all>

</div>