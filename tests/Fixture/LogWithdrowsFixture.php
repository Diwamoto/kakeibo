<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LogWithdrowsFixture
 */
class LogWithdrowsFixture extends TestFixture
{
    /**
     * Fields
     *
     * @var array
     */
    // phpcs:disable
    public $fields = [
        'id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '', 'autoIncrement' => true, 'precision' => null],
        'user_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '登録者id', 'precision' => null, 'autoIncrement' => null],
        'place' => ['type' => 'text', 'length' => null, 'null' => true, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '場所', 'precision' => null],
        'withdrow_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '出金カテゴリid', 'precision' => null, 'autoIncrement' => null],
        'account_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '出金元口座id', 'precision' => null, 'autoIncrement' => null],
        'amount' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => true, 'default' => null, 'comment' => '出金額', 'precision' => null, 'autoIncrement' => null],
        'payment_method_id' => ['type' => 'integer', 'length' => 11, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '出金方法id', 'precision' => null, 'autoIncrement' => null],
        'fix_flg' => ['type' => 'tinyinteger', 'length' => 4, 'unsigned' => false, 'null' => false, 'default' => null, 'comment' => '修正フラグ', 'precision' => null],
        'comment' => ['type' => 'text', 'length' => null, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_unicode_ci', 'comment' => '備考', 'precision' => null],
        'created' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => null, 'comment' => '作成日'],
        'modified' => ['type' => 'datetime', 'length' => null, 'precision' => null, 'null' => false, 'default' => null, 'comment' => '更新日'],
        '_indexes' => [
            'user_id' => ['type' => 'index', 'columns' => ['user_id'], 'length' => []],
            'withdrow_id' => ['type' => 'index', 'columns' => ['withdrow_id'], 'length' => []],
            'account_id' => ['type' => 'index', 'columns' => ['account_id'], 'length' => []],
            'payment_method_id' => ['type' => 'index', 'columns' => ['payment_method_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['id'], 'length' => []],
            'log_withdrows_ibfk_1' => ['type' => 'foreign', 'columns' => ['user_id'], 'references' => ['users', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'log_withdrows_ibfk_10' => ['type' => 'foreign', 'columns' => ['payment_method_id'], 'references' => ['mst_payment_methods', 'key'], 'update' => 'restrict', 'delete' => 'noAction', 'length' => []],
            'log_withdrows_ibfk_2' => ['type' => 'foreign', 'columns' => ['withdrow_id'], 'references' => ['mst_withdraws', 'key'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'log_withdrows_ibfk_3' => ['type' => 'foreign', 'columns' => ['user_id'], 'references' => ['users', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'log_withdrows_ibfk_4' => ['type' => 'foreign', 'columns' => ['withdrow_id'], 'references' => ['mst_withdraws', 'key'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'log_withdrows_ibfk_5' => ['type' => 'foreign', 'columns' => ['account_id'], 'references' => ['accounts', 'id'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'log_withdrows_ibfk_6' => ['type' => 'foreign', 'columns' => ['payment_method_id'], 'references' => ['mst_payment_methods', 'key'], 'update' => 'restrict', 'delete' => 'restrict', 'length' => []],
            'log_withdrows_ibfk_7' => ['type' => 'foreign', 'columns' => ['user_id'], 'references' => ['users', 'id'], 'update' => 'restrict', 'delete' => 'noAction', 'length' => []],
            'log_withdrows_ibfk_8' => ['type' => 'foreign', 'columns' => ['withdrow_id'], 'references' => ['mst_withdraws', 'key'], 'update' => 'restrict', 'delete' => 'noAction', 'length' => []],
            'log_withdrows_ibfk_9' => ['type' => 'foreign', 'columns' => ['account_id'], 'references' => ['accounts', 'id'], 'update' => 'restrict', 'delete' => 'noAction', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8mb4_unicode_ci'
        ],
    ];
    // phpcs:enable
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'user_id' => 1,
                'place' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'withdrow_id' => 1,
                'account_id' => 1,
                'amount' => 1,
                'payment_method_id' => 1,
                'fix_flg' => 1,
                'comment' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'created' => '2020-05-07 22:57:38',
                'modified' => '2020-05-07 22:57:38',
            ],
        ];
        parent::init();
    }
}
