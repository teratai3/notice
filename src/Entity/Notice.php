<?php

namespace Drupal\notice\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Field\BaseFieldDefinition;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Entity\EntityStorageInterface;

/**
 * Defines the Notice entity.
 *
 * @ContentEntityType(
 *   id = "notice",
 *   label = @Translation("管理者お知らせ"),
 *   label_collection = @Translation("管理者お知らせ"),
 *   base_table = "notices",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "title"
 *   },
 *   handlers = {
 *     "storage_schema" = "Drupal\notice\NoticeStorageSchema",
 *     "view_builder" = "Drupal\Core\Entity\EntityViewBuilder",
 *     "list_builder" = "Drupal\notice\NoticeListBuilder",
 *     "views_data" = "Drupal\views\EntityViewsData",
 * 
 *     "form" = {
 *       "default" = "Drupal\notice\Form\NoticeForm",
 *       "add" = "Drupal\notice\Form\NoticeForm",
 *       "edit" = "Drupal\notice\Form\NoticeForm",
 *       "delete" = "Drupal\notice\Form\NoticeDeleteForm"
 *     },
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     }
 *   },
 *   admin_permission = "administer site configuration",
 *   links = {
 *     "canonical" = "/admin/notice/{notice}",
 *     "edit-form" = "/admin/notice/{notice}/edit",
 *     "delete-form" = "/admin/notice/{notice}/delete",
 *     "collection" = "/admin/notice",
 *     "add-form" = "/admin/notice/add"
 *   },
 * )
 */
class Notice extends ContentEntityBase
{

    /**
     * {@inheritdoc}
     */
    public static function baseFieldDefinitions(EntityTypeInterface $entity_type)
    {
        $fields = parent::baseFieldDefinitions($entity_type);

        // https://gist.github.com/cesarmiquel/48404d99c8f7d9f274705b7a601c5554
        // https://chatdeoshiete.com/node/3526

        $fields['title'] = BaseFieldDefinition::create('string')
            ->setLabel('タイトル')
            ->setRequired(true)
            ->setSettings([
                'max_length' => 255,
            ])
            ->setDisplayOptions('view', [
                'label' => 'hidden',
                'type' => 'string',
                'weight' => 1,
            ])
            ->setDisplayOptions('form', [
                'type' => 'text',
                'weight' => 0,
            ]);


        $fields['description'] = BaseFieldDefinition::create('string_long')
            ->setLabel('説明文')
            ->setDisplayOptions('view', [
                'label' => 'above',
                'type' => 'text',
                'weight' => 1,
            ])
            ->setDisplayOptions('form', [
                'type' => 'text',
                'weight' => 0,
            ]);

        $fields['start_date'] = BaseFieldDefinition::create('datetime')
            ->setLabel('開始日')
            ->setRequired(true)
            ->setDisplayOptions('view', [
                'label' => 'inline',
                'type' => 'datetime_default',
                'weight' => 1,
            ])
            ->setDisplayOptions('form', [
                'type' => 'datetime_default',
                'weight' => 0,
            ]);

        $fields['end_date'] = BaseFieldDefinition::create('datetime')
            ->setLabel('終了日')
            ->setRequired(true)
            ->setDisplayOptions('view', [
                'label' => 'inline',
                'type' => 'datetime_default',
                'weight' => 2,
            ])
            ->setDisplayOptions('form', [
                'type' => 'datetime_default',
                'weight' => 1,
            ]);

        // ユーザーロールフィールドを追加
        $fields['user_roles'] = BaseFieldDefinition::create('entity_reference')
            ->setLabel('ユーザー権限')
            ->setDescription('このお知らせを表示するユーザー権限を選択してください。')
            ->setCardinality(BaseFieldDefinition::CARDINALITY_UNLIMITED)
            ->setRequired(true)
            ->setSetting('target_type', 'user_role') // 参照するエンティティタイプをユーザーロールに設定
            ->setSetting('handler', 'default') // デフォルトのハンドラを使用する設定
            ->setDisplayOptions('view', [
                'label' => 'above',
                'type' => 'entity_reference_label',
                'weight' => 3,
            ])
            ->setDisplayOptions('form', [
                'type' => 'entity_reference_autocomplete', // フォームでの入力形式をエンティティ参照オートコンプリートに設定
                'weight' => 2,
                'settings' => [
                    'match_operator' => 'CONTAINS',
                    'size' => 60,
                    'autocomplete_type' => 'tags',
                    'placeholder' => '',
                ],
            ]);

            
        $fields['created_at'] = BaseFieldDefinition::create('created')
            ->setLabel("作成日時")
            ->setRequired(true);

        $fields['updated_at'] = BaseFieldDefinition::create('changed')
            ->setLabel("更新日時")
            ->setRequired(true);

        return $fields;
    }
}
