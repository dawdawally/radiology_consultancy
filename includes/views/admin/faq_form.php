<?php $isEdit = !empty($item); ?>
<div class="admin-card">
    <form method="POST" action="<?= adminUrl('page=faq&action=' . ($isEdit ? 'edit' : 'create')) ?>">
        <?= csrfField() ?>
        <?php if ($isEdit): ?><input type="hidden" name="id" value="<?= (int) $item['id'] ?>"><?php endif; ?>
        <div class="row g-3">
            <div class="col-12">
                <label class="form-label">Question *</label>
                <input type="text" name="question" class="form-control" value="<?= e($item['question'] ?? '') ?>" required maxlength="500">
            </div>
            <div class="col-12">
                <label class="form-label">Answer *</label>
                <textarea name="answer" class="form-control" rows="8" required><?= e($item['answer'] ?? '') ?></textarea>
                <div class="form-text">HTML is allowed (e.g. &lt;p&gt;, &lt;strong&gt;, &lt;ul&gt;).</div>
            </div>
            <div class="col-md-3">
                <label class="form-label">Sort Order</label>
                <input type="number" name="sort_order" class="form-control" value="<?= e((string) ($item['sort_order'] ?? 0)) ?>">
            </div>
            <div class="col-12">
                <div class="form-check">
                    <input type="checkbox" name="is_published" class="form-check-input" id="faqPub" <?= ($item['is_published'] ?? 1) ? 'checked' : '' ?>>
                    <label class="form-check-label" for="faqPub">Published</label>
                </div>
            </div>
        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Save</button>
            <a href="<?= adminUrl('page=faq') ?>" class="btn btn-outline-secondary ms-2">Cancel</a>
        </div>
    </form>
</div>
