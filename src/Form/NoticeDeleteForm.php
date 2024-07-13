<?php

namespace Drupal\notice\Form;

use Drupal\Core\Entity\ContentEntityDeleteForm;


class NoticeDeleteForm extends ContentEntityDeleteForm
{

  /**
   * {@inheritdoc}
   */
  public function getQuestion()
  {
    return "このお知らせ{$this->entity->label()}を削除してもよろしいですか？";
  }

  /**
   * {@inheritdoc}
   */
  public function getCancelUrl()
  {
    return $this->entity->toUrl('collection');
  }

  /**
   * {@inheritdoc}
   */
  public function getConfirmText()
  {
    return '削除';
  }

  /**
   * {@inheritdoc}
   */
  public function getDescription()
  {
    return 'この操作は元に戻せません。';
  }
}
