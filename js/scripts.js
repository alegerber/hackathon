jQuery(document).ready(function ($) {
	const ctx = document.getElementById("mdbhc-chart");
	if (ctx) {
		$.ajax({
			type: "post",
			data: { action: "mdbhc_executiontime", nonce: mdbhc.nonce },
			url: mdbhc.ajaxUrl,
			success: function (response) {
				const labels = [];
				const execTime = [];
				const averageQueries = [];

				response.data.forEach((res, i) => {
					const resPrevDate = response[i - 1]?.date;
					if (resPrevDate !== res.date && resPrevDate !== undefined) {
						labels.push(res.date);
					} else {
						labels.push("");
					}
					execTime.push(Math.round(res.microseconds));
					averageQueries.push(res["queries-num"]);
				});

				datasets: [
					{
						label: "Average execution time in μS",
						data: execTime,
						borderWidth: 1,
						yAxisID: "y",
					},
					{
						label: "Queries",
						data: averageQueries,
						borderWidth: 1,
						yAxisID: "y1",
					},
				]

				if (response.config.high_contrast) {
					Chart.defaults.backgroundColor = '#FFFFFF';
					Chart.defaults.borderColor = '#000000';
					Chart.defaults.color = '#000000';
					dataset[0].borderWidth = 3;
					dataset[0].borderColor = '#000000';
					dataset[1].borderWidth = 3;
					dataset[1].borderColor = '#000000';
				}

				new Chart(ctx, {
					type: "line",
					data: {
						labels: labels,
						datasets: datasets,
					},
					options: {
						scales: {
							y: {
								beginAtZero: true,
								title: {
									display: true,
									text: "Execution time",
									color: "#4DAAED",
									font: {
										size: 20,
										style: "normal",
										lineHeight: 2,
									},
								},
								type: "linear",
								display: true,
								position: "left",
							},
							y1: {
								beginAtZero: true,
								title: {
									display: true,
									text: "Queries",
									color: "#FF7390",
									font: {
										size: 20,
										style: "normal",
										lineHeight: 2,
									},
								},
								type: "linear",
								display: true,
								position: "right",

								// grid line settings
								grid: {
									drawOnChartArea: false, // only want the grid lines for one axis to show up
								},
							},
							x: {
								ticks: {
									callback: function (val, index) {
										if (this.getLabelForValue(val) != "") {
											return this.getLabelForValue(val);
										}
									},
								},
							},
						},
						responsive: true,
						interaction: {
							mode: "index",
							intersect: false,
						},
						stacked: false,
					},
				});
			},
		});
	}
});
