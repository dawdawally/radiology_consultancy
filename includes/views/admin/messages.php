<div class="row g-4">
    <div class="col-lg-5">
        <div class="admin-card">
            <h5 class="mb-3">Inbox</h5>
            <?php if (empty($messages)): ?>
            <p class="text-muted">No messages yet.</p>
            <?php else: ?>
            <div class="list-group list-group-flush">
                <?php foreach ($messages as $msg): ?>
                <a href="<?= adminUrl('page=messages&view=' . $msg['id']) ?>" class="list-group-item list-group-item-action <?= ($viewMessage['id'] ?? 0) == $msg['id'] ? 'active' : '' ?>">
                    <div class="d-flex justify-content-between">
                        <strong><?= e($msg['name']) ?></strong>
                        <?php if (!$msg['is_read']): ?><span class="badge bg-danger">New</span><?php endif; ?>
                    </div>
                    <small><?= e(truncate($msg['subject'] ?: ($msg['topic'] ? contactTopicLabel($msg['topic'], $services ?? []) : $msg['message']), 50)) ?></small>
                    <small class="d-block text-muted"><?= formatDate($msg['created_at'], 'd M Y H:i') ?></small>
                </a>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-lg-7">
        <div class="admin-card">
            <?php if ($viewMessage): ?>
            <?php
            $messageTitle = $viewMessage['subject']
                ?: (!empty($viewMessage['topic']) ? contactTopicLabel($viewMessage['topic'], $services ?? []) : 'Consultation Request');
            $replySubject = 'Re: ' . $messageTitle;
            ?>
            <h5 class="mb-3"><?= e($messageTitle) ?></h5>
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
