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
                    <small><?= e(truncate($msg['subject'] ?? $msg['message'], 50)) ?></small>
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
            <h5 class="mb-3"><?= e($viewMessage['subject'] ?: 'Consultation Request') ?></h5>
            <dl class="row mb-4">
                <dt class="col-sm-3">From</dt><dd class="col-sm-9"><?= e($viewMessage['name']) ?> &lt;<?= e($viewMessage['email']) ?>&gt;</dd>
                <?php if ($viewMessage['phone']): ?><dt class="col-sm-3">Phone</dt><dd class="col-sm-9"><?= e($viewMessage['phone']) ?></dd><?php endif; ?>
                <dt class="col-sm-3">Date</dt><dd class="col-sm-9"><?= formatDate($viewMessage['created_at'], 'd M Y H:i') ?></dd>
                <dt class="col-sm-3">Message</dt><dd class="col-sm-9"><div class="border rounded p-3 bg-light"><?= nl2br(e($viewMessage['message'])) ?></div></dd>
            </dl>

            <h6 class="mb-3">Reply</h6>
            <form method="POST" action="<?= adminUrl('page=messages&action=reply') ?>">
                <?= csrfField() ?>
                <input type="hidden" name="message_id" value="<?= (int) $viewMessage['id'] ?>">
                <div class="mb-3">
                    <label class="form-label">To</label>
                    <input type="text" class="form-control" value="<?= e($viewMessage['name'] . ' <' . $viewMessage['email'] . '>') ?>" readonly>
                </div>
                <div class="mb-3">
                    <label class="form-label">Subject</label>
                    <input type="text" name="subject" class="form-control" required value="<?= e('Re: ' . ($viewMessage['subject'] ?: 'Your enquiry')) ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Your reply</label>
                    <textarea name="body" class="form-control" rows="8" required placeholder="Type your response to the client..."></textarea>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <button type="submit" class="btn btn-primary"><i class="fa-solid fa-paper-plane me-1"></i>Send Reply</button>
                    <a href="<?= e(replyMailtoUrl($viewMessage)) ?>" class="btn btn-outline-secondary">Open in Email App</a>
                </div>
            </form>
            <?php else: ?>
            <p class="text-muted mb-0">Select a message to view details.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
