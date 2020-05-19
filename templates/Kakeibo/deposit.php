<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
$datas = "[" . implode(',', $deposits) . "]";
?>
<h3 class="center-align" style="margin-top:75px"><?php echo (int) date('m') . '月 入金一覧'?></h3>
<div class="graph">
        <div class="center-align">
            <a class="btn disabled" href="/kakeibo/deposit">入金</a> | <a class="btn" href="/kakeibo/withdraw">出金</a>
        </div>

    <canvas id="myPieChart"></canvas>
</div>
<a class="center-align" href="/users/logout">ログアウト</a>
<script src="https://cdnjs.cloudflare.com/ajax/libs/randomcolor/0.5.4/randomColor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.bundle.js"></script>
<script>
    var category = Object.values(JSON.parse('<?php echo $category; ?>'));
    var ctx = document.getElementById("myPieChart");
    var color = randomColor({luminosity: 'light', count: 10});
    var myPieChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: category,
            datasets: [{
                backgroundColor: color,
                data: <?php echo $datas;?>
            }]
        },
        options: {
            title: {
                display: false,
                text: "<?php echo ltrim(date('m')) , '月 入金一覧'?>"
            }
        }
    });
</script>