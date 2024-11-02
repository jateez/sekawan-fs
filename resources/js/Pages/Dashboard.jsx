import React, { useState } from "react";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import {
    Chart as ChartJS,
    CategoryScale,
    LinearScale,
    BarElement,
    Title,
    Tooltip,
    Legend,
} from "chart.js";
import { Bar } from "react-chartjs-2";
import { router } from "@inertiajs/react";

// Register ChartJS components
ChartJS.register(
    CategoryScale,
    LinearScale,
    BarElement,
    Title,
    Tooltip,
    Legend
);

export default function Dashboard({ vehicles }) {
    const [timeframe, setTimeframe] = useState("month");
    const [exportForm, setExportForm] = useState({
        start_date: "",
        end_date: "",
        report_type: "monthly",
    });

    // Process vehicle status data
    const statusData = {
        labels: ["Available", "In-Use", "Maintenance", "Assigned"],
        datasets: [
            {
                label: "Vehicles by Status",
                data: [
                    vehicles.filter((v) => v.status === "available").length,
                    vehicles.filter((v) => v.status === "in-use").length,
                    vehicles.filter((v) => v.status === "maintenance").length,
                    vehicles.filter((v) => v.status === "assigned").length,
                ],
                backgroundColor: [
                    "#4ade80", // green-400 for available
                    "#60a5fa", // blue-400 for in-use
                    "#f87171", // red-400 for maintenance
                    "#fbbf24", // amber-400 for assigned
                ],
            },
        ],
    };

    // Calculate summary stats
    const totalVehicles = vehicles.length;
    const availableVehicles = vehicles.filter(
        (v) => v.status === "available"
    ).length;
    const maintenanceVehicles = vehicles.filter(
        (v) => v.status === "maintenance"
    ).length;
    const totalUsage = vehicles.reduce((sum, v) => sum + v.total_usage, 0);

    const handleExport = (e) => {
        e.preventDefault();
        router.post("/export-report", exportForm, {
            preserveState: true,
            preserveScroll: true,
        });
    };

    return (
        <AuthenticatedLayout>
            <div className="min-h-screen bg-gray-50 px-6 lg:px-24 py-12">
                <h1 className="text-3xl font-bold mb-6 text-center">
                    Vehicle Dashboard
                </h1>

                {/* Summary Stats */}
                <div className="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                    <div className="stat bg-base-100 shadow-xl rounded-box">
                        <div className="stat-title">Total Vehicles</div>
                        <div className="stat-value text-primary">
                            {totalVehicles}
                        </div>
                    </div>
                    <div className="stat bg-base-100 shadow-xl rounded-box">
                        <div className="stat-title">Available Vehicles</div>
                        <div className="stat-value text-success">
                            {availableVehicles}
                        </div>
                    </div>
                    <div className="stat bg-base-100 shadow-xl rounded-box">
                        <div className="stat-title">In Maintenance</div>
                        <div className="stat-value text-error">
                            {maintenanceVehicles}
                        </div>
                    </div>
                    <div className="stat bg-base-100 shadow-xl rounded-box">
                        <div className="stat-title">Total Usage</div>
                        <div className="stat-value">
                            {totalUsage.toLocaleString()} km
                        </div>
                    </div>
                </div>

                {/* Charts Section */}
                <div className="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                    {/* Vehicle Status Distribution */}
                    <div className="card bg-base-100 shadow-xl">
                        <div className="card-body">
                            <h2 className="card-title">
                                Vehicle Status Distribution
                            </h2>
                            <div className="w-full">
                                <Bar
                                    data={statusData}
                                    options={{ responsive: true }}
                                />
                            </div>
                        </div>
                    </div>

                    {/* Gas Consumption by Vehicle */}
                    <div className="card bg-base-100 shadow-xl">
                        <div className="card-body">
                            <h2 className="card-title">
                                Latest Gas Consumption
                            </h2>
                            <div className="w-full">
                                <Bar
                                    data={{
                                        labels: vehicles.map((v) => v.model),
                                        datasets: [
                                            {
                                                label: "Liters",
                                                data: vehicles.map(
                                                    (v) =>
                                                        v.latest_gas_consumption
                                                            ?.liters || 0
                                                ),
                                                backgroundColor: "#60a5fa",
                                            },
                                        ],
                                    }}
                                    options={{ responsive: true }}
                                />
                            </div>
                        </div>
                    </div>
                </div>

                {/* Vehicle Cards */}
                <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    {vehicles.map((vehicle) => (
                        <div
                            key={vehicle.id}
                            className="card bg-base-100 shadow-lg hover:shadow-xl transition-shadow duration-300"
                        >
                            <div className="card-body p-6">
                                <div className="flex justify-between items-start mb-2">
                                    <h3 className="text-xl font-semibold">
                                        {vehicle.model}
                                    </h3>
                                    <div
                                        className={`badge ${
                                            vehicle.status === "available"
                                                ? "badge-success"
                                                : vehicle.status ===
                                                  "maintenance"
                                                ? "badge-error"
                                                : vehicle.status === "in-use"
                                                ? "badge-info"
                                                : "badge-warning"
                                        }`}
                                    >
                                        {vehicle.status}
                                    </div>
                                </div>
                                <div className="divider my-2"></div>
                                <p className="text-gray-700 mb-1">
                                    <span className="font-medium">
                                        Last Gas:
                                    </span>{" "}
                                    {vehicle.latest_gas_consumption?.liters ||
                                        0}{" "}
                                    liters
                                </p>
                                <p className="text-gray-700 mb-1">
                                    <span className="font-medium">
                                        Next Service:
                                    </span>{" "}
                                    {vehicle.next_service_date ||
                                        "Not scheduled"}
                                </p>
                                <p className="text-gray-700">
                                    <span className="font-medium">
                                        Total Usage:
                                    </span>{" "}
                                    {vehicle.total_usage.toLocaleString()} km
                                </p>
                                <progress
                                    className="progress progress-primary mt-3"
                                    value={
                                        vehicle.odometer %
                                        vehicle.service_interval
                                    }
                                    max={vehicle.service_interval}
                                ></progress>
                                <p className="text-xs text-gray-500 text-center mt-1">
                                    {vehicle.service_interval -
                                        (vehicle.odometer %
                                            vehicle.service_interval)}{" "}
                                    km until next service
                                </p>
                            </div>
                        </div>
                    ))}
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
