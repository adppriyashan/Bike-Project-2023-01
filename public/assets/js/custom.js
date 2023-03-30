new Chart($("#rides_availability"), {
    type: "doughnut",
    data: {
        labels: ["Available", "Not Available"],
        datasets: [
            {
                label: "# of Votes",
                data: ridesAvailability,
                borderWidth: 1,
            },
        ],
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
            },
        },
    },
});

new Chart($("#rides_reservations"), {
    type: "bar",
    data: {
        labels: ridesReservationsDates,
        datasets: [
            {
                label: "Sales of last ten days",
                data: ridesReservations,
                backgroundColor: [
                    "rgba(16, 135, 211, 1)",
                    "rgba(255, 115, 24, 1)",
                    "rgba(34, 167, 120, 1)",
                    "rgba(255, 24, 55, 1)",
                    "rgba(16, 135, 211, 1)",
                    "rgba(255, 115, 24, 1)",
                    "rgba(34, 167, 120, 1)",
                    "rgba(255, 24, 55, 1)",
                    "rgba(16, 135, 211, 1)",
                    "rgba(255, 115, 24, 1)",
                ],
                borderColor: [
                    "rgba(16, 135, 211, 1)",
                    "rgba(255, 115, 24, 1)",
                    "rgba(34, 167, 120, 1)",
                    "rgba(255, 24, 55, 1)",
                    "rgba(16, 135, 211, 1)",
                    "rgba(255, 115, 24, 1)",
                    "rgba(34, 167, 120, 1)",
                    "rgba(255, 24, 55, 1)",
                    "rgba(16, 135, 211, 1)",
                    "rgba(255, 115, 24, 1)",
                ],
                borderWidth: 1,
            },
        ],
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
            },
        },
    },
});

new Chart($("#sales_reservations"), {
    type: "line",
    data: {
        labels: ridesReservationsDates,
        datasets: [
            {
                label: "Sales of last ten days",
                data: ridesReservations,
                backgroundColor: [
                    "rgba(16, 135, 211, 1)",
                    "rgba(255, 115, 24, 1)",
                    "rgba(34, 167, 120, 1)",
                    "rgba(255, 24, 55, 1)",
                    "rgba(16, 135, 211, 1)",
                    "rgba(255, 115, 24, 1)",
                    "rgba(34, 167, 120, 1)",
                    "rgba(255, 24, 55, 1)",
                    "rgba(16, 135, 211, 1)",
                    "rgba(255, 115, 24, 1)",
                ],
                borderColor: [
                    "rgba(16, 135, 211, 1)",
                    "rgba(255, 115, 24, 1)",
                    "rgba(34, 167, 120, 1)",
                    "rgba(255, 24, 55, 1)",
                    "rgba(16, 135, 211, 1)",
                    "rgba(255, 115, 24, 1)",
                    "rgba(34, 167, 120, 1)",
                    "rgba(255, 24, 55, 1)",
                    "rgba(16, 135, 211, 1)",
                    "rgba(255, 115, 24, 1)",
                ],
                borderWidth: 1,
            },
        ],
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
            },
        },
    },
});

new Chart($("#sales_reservations_scatter"), {
    type: "radar",
    data: {
        labels: ridesReservationsDates,
        datasets: [
            {
                label: "Sales of last ten days",
                data: ridesReservations,
                backgroundColor: [
                    "rgba(16, 135, 211, 1)",
                    "rgba(255, 115, 24, 1)",
                    "rgba(34, 167, 120, 1)",
                    "rgba(255, 24, 55, 1)",
                    "rgba(16, 135, 211, 1)",
                    "rgba(255, 115, 24, 1)",
                    "rgba(34, 167, 120, 1)",
                    "rgba(255, 24, 55, 1)",
                    "rgba(16, 135, 211, 1)",
                    "rgba(255, 115, 24, 1)",
                ],
                borderColor: [
                    "rgba(16, 135, 211, 1)",
                    "rgba(255, 115, 24, 1)",
                    "rgba(34, 167, 120, 1)",
                    "rgba(255, 24, 55, 1)",
                    "rgba(16, 135, 211, 1)",
                    "rgba(255, 115, 24, 1)",
                    "rgba(34, 167, 120, 1)",
                    "rgba(255, 24, 55, 1)",
                    "rgba(16, 135, 211, 1)",
                    "rgba(255, 115, 24, 1)",
                ],
                borderWidth: 1,
            },
        ],
    },
    options: {
        scales: {
            y: {
                beginAtZero: true,
            },
        },
    },
});
