// resources/assets/js/totalAmount.js

'use strict';

(function () {
  // Step 1: Get all amounts from the Blade view
  const amounts = JSON.parse(document.getElementById('amounts-data').textContent);

  // Step 2: Calculate the total sum of all amounts
  const totalAmount = amounts.reduce((sum, amount) => sum + amount, 0);

  // Step 3: Format the total sum (add commas and currency symbol)
  const formattedAmount = `₱${totalAmount.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;

  // Step 4: Display the total amount in the HTML
  document.getElementById('totalAmountDisplay').textContent = formattedAmount;
  document.getElementById('totalAmountText').textContent = formattedAmount;

  // Step 5: Configure the chart (use the amounts as data for the chart)
  const amountLineChartConfig = {
    chart: {
      height: 350,
      type: 'line',
      toolbar: { show: false }
    },
    series: [
      {
        name: 'Amount',
        data: amounts
      }
    ],
    xaxis: {
      categories: amounts.map((_, index) => index + 1),
      title: { text: 'Entry Index' }
    },
    yaxis: {
      title: { text: 'Amount' }
    },
    stroke: { width: 3 },
    markers: {
      size: 6,
      colors: ['#7367f0'],
      strokeColors: '#ffffff',
      strokeWidth: 3,
      hover: { size: 7 }
    },
    tooltip: {
      shared: false,
      intersect: true,
      x: { show: false }
    }
  };

  const totalProfitLineChartEl = document.querySelector('#totalProfitLineChart');

  if (totalProfitLineChartEl !== undefined && totalProfitLineChartEl !== null) {
    const totalProfitLineChart = new ApexCharts(totalProfitLineChartEl, amountLineChartConfig);
    totalProfitLineChart.render();
  }
})();
