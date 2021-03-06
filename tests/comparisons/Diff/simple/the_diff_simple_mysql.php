<?php
use Migrations\AbstractMigration;

class TheDiffSimpleMysql extends AbstractMigration
{

    public function up()
    {

        $this->table('users')
            ->addColumn('username', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('password', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->create();

        $this->table('articles')
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'length' => 11,
                'null' => false,
            ])
            ->addIndex(
                [
                    'user_id',
                ],
                [
                    'name' => 'user_id',
                ]
            )
            ->update();

        $this->table('articles')
            ->addForeignKey(
                'user_id',
                'users',
                'id',
                [
                    'update' => 'RESTRICT',
                    'delete' => 'RESTRICT'
                ]
            )
            ->update();
    }

    public function down()
    {
        $this->table('articles')
            ->dropForeignKey(
                'user_id'
            );

        $this->table('articles')
            ->removeIndexByName('user_id')
            ->update();

        $this->table('articles')
            ->removeColumn('user_id')
            ->update();

        $this->dropTable('users');
    }
}

