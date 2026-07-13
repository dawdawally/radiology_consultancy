<div class="row g-4">
    <div class="col-lg-5">
        <div class="admin-card" id="messagesInbox">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Inbox</h5>
                <span class="badge bg-secondary" id="messagesCount"><?= count($messages) ?></span>
            </div>

            <?php if (empty($messages)): ?>
            <p class="text-muted mb-0">No messages yet.</p>
            <?php else: ?>
            <div class="messages-toolbar mb-3">
                <div class="input-group input-group-sm mb-2">
                    <span class="input-group-text"><i class="fa-solid fa-magnifying-glass"></i></span>
                    <input type="search" id="messagesSearch" class="form-control" placeholder="Search name, email, topic, message..." autocomplete="off">
                </div>
                <select id="messagesSort" class="form-select form-select-sm" aria-label="Sort messages">
                    <option value="date-desc">Newest first</option>
                    <option value="date-asc">Oldest first</option>
                    <option value="subject-asc">Subject A–Z</option>
                    <option value="subject-desc">Subject Z–A</option>
                </select>
            </div>

            <div class="list-group list-group-flush" id="messagesList">
                <?php foreach ($messages as $msg): ?>
                <?php
                $displaySubject = messageDisplaySubject($msg, $services ?? []);
                $searchText = strtolower(implode(' ', array_filter([
                    $msg['name'] ?? '',
                    $msg['email'] ?? '',
                    $msg['phone'] ?? '',
                    $displaySubject,
                    $msg['message'] ?? '',
                ])));
                ?>
                <div class="message-inbox-row <?= ($viewMessage['id'] ?? 0) == $msg['id'] ? 'is-active' : '' ?>"
                     data-subject="<?= e(strtolower($displaySubject)) ?>"
                     data-date="<?= (int) strtotime($msg['created_at']) ?>"
                     data-search="<?= e($searchText) ?>">
                    <a href="<?= adminUrl('page=messages&view=' . $msg['id']) ?>" class="list-group-item list-group-item-action message-inbox-link">
                        <div class="d-flex justify-content-between align-items-start gap-2">
                            <strong class="message-inbox-name"><?= e($msg['name']) ?></strong>
                            <?php if (!$msg['is_read']): ?><span class="badge bg-danger flex-shrink-0">New</span><?php endif; ?>
                        </div>
                        <small class="message-inbox-subject d-block"><?= e(truncate($displaySubject, 50)) ?></small>
                        <small class="d-block text-muted message-inbox-date"><?= formatDate($msg['created_at'], 'd M Y H:i') ?></small>
                    </a>
                    <a href="<?= adminUrl('page=messages&action=delete&id=' . $msg['id'] . '&csrf_token=' . csrfToken()) ?>"
                       class="message-inbox-delete btn btn-sm btn-outline-danger"
                       title="Delete message"
                       data-confirm="Delete this message and all replies?">
                        <i class="fa-solid fa-trash-can"></i>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
            <p class="text-muted small mt-3 mb-0 d-none" id="messagesNoResults">No messages match your search.</p>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="admin-card">
            <?php if ($viewMessage): ?>
            <?php
            $messageTitle = messageDisplaySubject($viewMessage, $services ?? []);
            $replySubject = 'Re: ' . $messageTitle;
            ?>
            <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                <h5 class="mb-0"><?= e($messageTitle) ?></h5>
                <a href="<?= adminUrl('page=messages&action=delete&id=' . $viewMessage['id'] . '&csrf_token=' . csrfToken()) ?>"
                   class="btn btn-sm btn-outline-danger flex-shrink-0"
                   data-confirm="Delete this message and all replies?">
                    <i class="fa-solid fa-trash-can me-1"></i>Delete
                </a>
            </div>
            <dl class="row mb-4">
                <dt class="col-sm-3">From</dt><dd class="col-sm-9"><?= e($viewMessage['name']) ?> &lt;<?= e($viewMessage['email']) ?>&gt;</dd>
                <?php if (!empty($viewMessage['topic'])): ?>
                <dt class="col-sm-3">Topic</dt><dd class="col-sm-9"><?= e(contactTopicLabel($viewMessage['topic'], $services ?? [])) ?></dd>
                <?php endif; ?>
                <?php if ($viewMessage['phone']): ?><dt class="col-sm-3">Phone</dt><dd class="col-sm-9"><?= e($viewMessage['phone']) ?></dd><?php endif; ?>
                <?php if (!empty($viewMessage['subject'])): ?><dt class="col-sm-3">Details</dt><dd class="col-sm-9"><?= e($viewMessage['subject']) ?></dd><?php endif; ?>
            </dl>

            <h6 class="mb-3">Conversation</h6>
            <div class="message-thread mb-4">
                <div class="thread-item thread-inbound">
                    <div class="thread-meta">
                        <strong><?= e($viewMessage['name']) ?></strong>
                        <span class="text-muted"><?= formatDate($viewMessage['created_at'], 'd M Y H:i') ?></span>
                    </div>
                    <div class="thread-body"><?= nl2br(e($viewMessage['message'])) ?></div>
                </div>

                <?php foreach ($replies as $reply): ?>
                <div class="thread-item thread-outbound">
                    <div class="thread-meta">
                        <strong><?= e($reply['admin_name'] ?: $reply['admin_username']) ?></strong>
                        <span class="text-muted"><?= formatDate($reply['created_at'], 'd M Y H:i') ?></span>
                        <?php if (!$reply['email_sent']): ?>
                        <span class="badge bg-warning text-dark">Email not sent</span>
                        <?php endif; ?>
                    </div>
                    <?php if ($reply['subject']): ?>
                    <div class="thread-subject text-muted small mb-1">Subject: <?= e($reply['subject']) ?></div>
                    <?php endif; ?>
                    <div class="thread-body"><?= nl2br(e($reply['body'])) ?></div>
                </div>
                <?php endforeach; ?>
            </div>

            <h6 class="mb-3">Reply</h6>
            <form method="POST" action="<?= adminUrl('page=messages&action=reply') ?>" data-loading-on-submit>
                <?= csrfField() ?>
                <input type="hidden" name="message_id" value="<?= (int) $viewMessage['id'] ?>">
                <div class="mb-3">
                    <label class="form-label">To</label>
                    <input type="text" class="form-control" value="<?= e($viewMessage['name'] . ' <' . $viewMessage['email'] . '>') ?>" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Subject</label>
                    <input type="text" name="subject" class="form-control" required value="<?= e($replySubject) ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Your reply</label>
                    <textarea name="body" class="form-control" rows="8" required placeholder="Type your response to the client..."></textarea>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <button type="submit" class="btn btn-primary" data-loading-text="Sending...">
                        <i class="fa-solid fa-paper-plane me-1"></i>Send Reply
                    </button>
                    <a href="<?= e(replyMailtoUrl($viewMessage)) ?>" class="btn btn-outline-secondary">Open in Email App</a>
                </div>
            </form>
            <?php else: ?>
            <p class="text-muted mb-0">Select a message to view details.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
