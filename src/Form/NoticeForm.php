<?php

namespace Drupal\notice\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;


class NoticeForm extends ContentEntityForm
{

    /**
     * {@inheritdoc}
     */
    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $form = parent::buildForm($form, $form_state);
        return $form;
    }

    public function validateForm(array &$form, FormStateInterface $form_state)
    {
        parent::validateForm($form, $form_state);

        //ユーザーロールのajaxでバリデーションが効いてエラーになるため
        if ($form_state->isSubmitted() && !$form_state->hasAnyErrors()) {
            $is_ajax = $form_state->getTriggeringElement()['#ajax'] ?? FALSE;
            if ($is_ajax) {
                return;
            }
        }

        // 開始日と終了日の値を取得
        $start_date = $form_state->getValue(['start_date', 0, 'value']);
        $end_date = $form_state->getValue(['end_date', 0, 'value']);


        if ($start_date && $end_date) {
            $start_date_time = new \DateTime($start_date);
            $end_date_time = new \DateTime($end_date);

            if ($start_date_time >= $end_date_time) {
                $form_state->setErrorByName('end_date', '終了日は開始日よりあとを入力してください');
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function save(array $form, FormStateInterface $form_state)
    {
        $entity = $this->entity;
        $status = parent::save($form, $form_state);
        $entity_label = $this->entity->label();

        switch ($status) {
            case SAVED_NEW:
                $this->messenger()->addStatus("{$entity_label}を作成しました。");
                break;

            default:
                $this->messenger()->addStatus("{$entity_label}を更新しました。");
        }

        $form_state->setRedirect('entity.notice.canonical', ['notice' => $entity->id()]);
    }
}
