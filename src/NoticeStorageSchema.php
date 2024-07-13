<?php

namespace Drupal\notice;

use Drupal\Core\Entity\ContentEntityTypeInterface;
use Drupal\Core\Entity\Sql\SqlContentEntityStorageSchema;
use Drupal\Core\Field\FieldStorageDefinitionInterface;

/**
 * Defines the notice schema handler.
 */
class NoticeStorageSchema extends SqlContentEntityStorageSchema
{

  /**
   * {@inheritdoc}
   */
  protected function getSharedTableFieldSchema(FieldStorageDefinitionInterface $storage_definition, $table_name, array $column_mapping)
  {
    $schema = parent::getSharedTableFieldSchema($storage_definition, $table_name, $column_mapping);
    $field_name = $storage_definition->getName();
  
    if ($table_name === 'notices') {
      if ($field_name === "title" || $field_name === "start_date" || $field_name === "end_date") {
        $schema['fields'][$field_name]['not null'] = true;
      }
    }

    return $schema;
  }
}
