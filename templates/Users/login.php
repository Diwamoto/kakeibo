<div class="row" style ="margin-top:100px;">
    <div class="col s12 m8 l4 offset-m2 offset-l4">
        <div class="card">

            <div class="card-action teal lighten-1 white-text">
                <h3>ユーザーログイン</h3>
            </div>
            <?= $this->Form->create() ?>
            <div class="card-content">
                <div class="form-field">
                    <?= $this->Form->control('name', ['required' => true]) ?>
                </div><br>

                <div class="form-field">
                    <?= $this->Form->control('password', ['required' => true]) ?>   
                </div><br>
                <div class="form-field center-align">
                    <?= $this->Form->submit(__('Login')); ?>
                </div><br>
                <?= $this->Form->end() ?>
            </div>

        </div>
    </div>
</div>