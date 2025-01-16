<div class="card">
                <div class="card-header">
                    <h3 class="card-title">Chat with Candidate</h3>
                   
                </div>
                <div class="card-body chat-box" id="chatBox">
                    <!-- Example Chat Messages -->
                    <div class="chat-message received">
                        <strong>Candidate:</strong>
                        <p>Hello! I'm excited about the opportunity.</p>
                        <small class="text-muted">10:00 AM</small>
                    </div>
                    <div class="chat-message sent">
                        <strong>You:</strong>
                        <p>Thank you for your interest. Let's discuss further.</p>
                        <small class="text-muted">10:05 AM</small>
                    </div>
                    <!-- More messages will be appended here dynamically -->
                </div>
                <div class="card-footer">
                    <form id="chatForm">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Type your message..." id="chatInput" required>
                            <button class="btn btn-primary" type="submit">Send</button>
                        </div>
                    </form>
                </div>
            </div>  