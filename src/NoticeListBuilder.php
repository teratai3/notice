<?php

namespace Drupal\notice;

use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Entity\EntityListBuilder;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of Notice entities.
 *
 * @ingroup notice
 */
class NoticeListBuilder extends EntityListBuilder
{

  /**
   * {@inheritdoc}
   */
  public function buildHeader()
  {
    $header['id'] = 'ID';
    $header['title'] = 'タイトル';
    $header['start_date'] = '開始日';
    $header['end_date'] = '終了日';
   
    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity)
  {

    $row['id'] = $entity->id();
    $row['title'] = $entity->toLink($entity->label());
    
    $start_date_value = $entity->get('start_date')->value;
    if ($start_date_value) {
      $start_date = new \DateTime($start_date_value);
      $row['start_date'] = $start_date->format('Y-m-d H:i:s');
    } else {
      $row['start_date'] = '';
    }

    $end_date_value = $entity->get('end_date')->value;
    if ($end_date_value) {
      $end_date = new \DateTime($end_date_value);
      $row['end_date'] = $end_date->format('Y-m-d H:i:s');
    } else {
      $row['end_date'] = '';
    }

    return $row + parent::buildRow($entity);
  }

  /**
   * {@inheritdoc}
   */
  public function render()
  {
    $build['add_button'] = [
      '#type' => 'link',
      '#title' => 'お知らせを新規追加',
      '#url' => Url::fromRoute('entity.notice.add_form'),
      '#attributes' => [
        'class' => ['button', 'button--action', 'button--primary'],
      ],
    ];
    
    $build['table'] = parent::render();
    return $build;
  }
}
