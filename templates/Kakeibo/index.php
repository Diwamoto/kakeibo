<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User[]|\Cake\Collection\CollectionInterface $users
 */
?>
<h1>円グラフ</h1>
<canvas id="myPieChart"></canvas>
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
                data: [43, 31, 21, 5]
            }]
        },
        options: {
            title: {
                display: true,
                text: '5月 家計簿'
            }
        }
    });
</script>