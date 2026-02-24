<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Article[] $articles
 */
?>

<div class="articles-container">
    <h1><?= __('My Articles') ?></h1>

    <?php if (empty($articles)): ?>
        <p><?= __('You have not written any articles yet.') ?></p>
        <?= $this->Html->link(__('Create Article'), ['action' => 'add'], ['class' => 'btn']) ?>
    <?php else: ?>
        <table class="table">
            <thead>
                <tr>
                    <th><?= __('Title') ?></th>
                    <th><?= __('Category') ?></th>
                    <th><?= __('Created') ?></th>
                    <th><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($articles as $article): ?>
                    <tr>
                        <td><?= h($article->title) ?></td>
                        <td><?= h($article->categorys->name ?? '') ?></td>
                        <td><?= $article->created->format('Y-m-d H:i') ?></td>
                        <td>
                            <?= $this->Html->link(__('View'), ['action' => 'view', $article->id]) ?>
                            <?= $this->Html->link(__('Edit'), ['action' => 'edit', $article->id]) ?>
                            <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $article->id], ['confirm' => __('Are you sure?')]) ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>