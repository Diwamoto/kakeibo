<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * MstAccountTypes Model
 *
 * @method \App\Model\Entity\MstAccountType newEmptyEntity()
 * @method \App\Model\Entity\MstAccountType newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\MstAccountType[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\MstAccountType get($primaryKey, $options = [])
 * @method \App\Model\Entity\MstAccountType findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\MstAccountType patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\MstAccountType[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\MstAccountType|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MstAccountType saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\MstAccountType[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\MstAccountType[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\MstAccountType[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\MstAccountType[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class MstAccountTypesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('mst_account_types');
        $this->setDisplayField('value');
        $this->setPrimaryKey('key');
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('key')
            ->allowEmptyString('key', null, 'create');

        $validator
            ->scalar('value')
            ->allowEmptyString('value');

        return $validator;
    }
}
