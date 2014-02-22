<?php
/* @var $this Mage_Core_Model_Resource_Setup */
$this->startSetup();

$table = $this->getConnection()->newTable($this->getTable('hackathon_frontendmonitoring/user_action'));

$table->addColumn(
    'action_id',
    Varien_Db_Ddl_Table::TYPE_INTEGER,
    10,
    array(
        'primary' => true,
        'identity' => true,
    ),
    'Action ID'
);

$table->addColumn(
    'session_id',
    Varien_Db_Ddl_Table::TYPE_TEXT,
    null,
    array(),
    'Session id of the active user'
);

$table->addColumn(
    'customer_id',
    Varien_Db_Ddl_Table::TYPE_INTEGER,
    null,
    array(
        'unsigned' => true,
        'nullable' => false,
    )
);

$table->addColumn(
    'model',
    Varien_Db_Ddl_Table::TYPE_TEXT,
    255,
    array(),
    'Model on which the action occured'
);

$table->addColumn(
    'action',
    Varien_Db_Ddl_Table::TYPE_TEXT,
    255,
    array(),
    'Action which occured on the model'
);

$table->addColumn(
    'timestamp',
    Varien_Db_Ddl_Table::TYPE_TIMESTAMP,
    null,
    array(),
    'Timestamp when the action occured'
);

$ddl = $this->getConnection()->createTable($table);

$this->endSetup();