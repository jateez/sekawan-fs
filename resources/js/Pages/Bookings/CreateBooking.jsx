import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Link, useForm } from "@inertiajs/react";
import { useState } from "react";

export default function CreateBooking({
    locations,
    vehicles,
    drivers,
    approvers,
}) {
    const { data, setData, post, processing, errors, reset } = useForm({
        location_id: "",
        vehicle_id: "",
        driver_id: "",
        start_date: "",
        end_date: "",
        approver_1: "",
        approver_2: "",
        purpose: "",
    });

    const [firstApprover, setFirstApprover] = useState(null);

    const handleSubmit = (e) => {
        e.preventDefault();
        post(route("bookings.store"), {
            onSuccess: () => reset(),
        });
    };

    const getSecondApproverOptions = () => {
        return approvers.filter(
            (approver) =>
                approver.id !== parseInt(data.approver_1) &&
                approver.approval_level === 2
        );
    };

    const FormField = ({ label, error, children }) => (
        <div className="form-control w-full">
            <label className="label">
                <span className="label-text font-medium text-sm md:text-base">
                    {label}
                </span>
            </label>
            {children}
            {error && (
                <label className="label">
                    <span className="label-text-alt text-error text-xs md:text-sm">
                        {error}
                    </span>
                </label>
            )}
        </div>
    );

    return (
        <AuthenticatedLayout>
            <div className="min-h-screen bg-gray-50 px-4 sm:px-6 lg:px-24 py-6 sm:py-12">
                <div className="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-4 sm:p-6 md:p-8">
                    <h2 className="text-xl sm:text-2xl font-bold text-gray-900 mb-4 sm:mb-6 text-center">
                        Create New Booking
                    </h2>

                    <form
                        onSubmit={handleSubmit}
                        className="space-y-4 sm:space-y-6"
                    >
                        {/* Location */}
                        <FormField label="Location" error={errors.location_id}>
                            <select
                                className={`select select-bordered w-full text-sm md:text-base ${
                                    errors.location_id ? "select-error" : ""
                                }`}
                                value={data.location_id}
                                onChange={(e) =>
                                    setData("location_id", e.target.value)
                                }
                            >
                                <option value="">Select a location</option>
                                {locations.map((location) => (
                                    <option
                                        key={location.id}
                                        value={location.id}
                                    >
                                        {location.name}
                                    </option>
                                ))}
                            </select>
                        </FormField>

                        {/* Vehicle */}
                        <FormField label="Vehicle" error={errors.vehicle_id}>
                            <select
                                className={`select select-bordered w-full text-sm md:text-base ${
                                    errors.vehicle_id ? "select-error" : ""
                                }`}
                                value={data.vehicle_id}
                                onChange={(e) =>
                                    setData("vehicle_id", e.target.value)
                                }
                            >
                                <option value="">Select a vehicle</option>
                                {vehicles
                                    .filter(
                                        (vehicle) =>
                                            vehicle.location_id.toString() ===
                                            data.location_id.toString()
                                    )
                                    .map((vehicle) => (
                                        <option
                                            key={vehicle.id}
                                            value={vehicle.id}
                                        >
                                            {vehicle.model} -{" "}
                                            {vehicle.plate_number}
                                        </option>
                                    ))}
                            </select>
                        </FormField>

                        {/* Driver */}
                        <FormField label="Driver" error={errors.driver_id}>
                            <select
                                className={`select select-bordered w-full text-sm md:text-base ${
                                    errors.driver_id ? "select-error" : ""
                                }`}
                                value={data.driver_id}
                                onChange={(e) =>
                                    setData("driver_id", e.target.value)
                                }
                            >
                                <option value="">Select a driver</option>
                                {drivers
                                    .filter(
                                        (driver) =>
                                            driver.location_id.toString() ===
                                            data.location_id.toString()
                                    )
                                    .map((driver) => (
                                        <option
                                            key={driver.id}
                                            value={driver.id}
                                        >
                                            {driver.name}
                                        </option>
                                    ))}
                            </select>
                        </FormField>

                        {/* Date Range */}
                        <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <FormField
                                label="Start Date & Time"
                                error={errors.start_date}
                            >
                                <input
                                    type="datetime-local"
                                    className={`input input-bordered w-full text-sm md:text-base ${
                                        errors.start_date ? "input-error" : ""
                                    }`}
                                    value={data.start_date}
                                    onChange={(e) =>
                                        setData("start_date", e.target.value)
                                    }
                                    min={new Date().toISOString().slice(0, 16)}
                                />
                            </FormField>

                            <FormField
                                label="End Date & Time"
                                error={errors.end_date}
                            >
                                <input
                                    type="datetime-local"
                                    className={`input input-bordered w-full text-sm md:text-base ${
                                        errors.end_date ? "input-error" : ""
                                    }`}
                                    value={data.end_date}
                                    onChange={(e) =>
                                        setData("end_date", e.target.value)
                                    }
                                    min={
                                        data.start_date ||
                                        new Date().toISOString().slice(0, 16)
                                    }
                                />
                            </FormField>
                        </div>

                        {/* Approvers */}
                        <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <FormField
                                label="First Approver"
                                error={errors.approver_1}
                            >
                                <select
                                    className={`select select-bordered w-full text-sm md:text-base ${
                                        errors.approver_1 ? "select-error" : ""
                                    }`}
                                    value={data.approver_1}
                                    onChange={(e) => {
                                        setData("approver_1", e.target.value);
                                        setFirstApprover(e.target.value);
                                        if (
                                            data.approver_2 === e.target.value
                                        ) {
                                            setData("approver_2", "");
                                        }
                                    }}
                                >
                                    <option value="">
                                        Select first approver
                                    </option>
                                    {approvers
                                        .filter(
                                            (approver) =>
                                                approver.approval_level === 1
                                        )
                                        .map((approver) => (
                                            <option
                                                key={approver.id}
                                                value={approver.id}
                                            >
                                                {approver.name}
                                            </option>
                                        ))}
                                </select>
                            </FormField>

                            <FormField
                                label="Second Approver"
                                error={errors.approver_2}
                            >
                                <select
                                    className={`select select-bordered w-full text-sm md:text-base ${
                                        errors.approver_2 ? "select-error" : ""
                                    }`}
                                    value={data.approver_2}
                                    onChange={(e) =>
                                        setData("approver_2", e.target.value)
                                    }
                                    disabled={!data.approver_1}
                                >
                                    <option value="">
                                        Select second approver
                                    </option>
                                    {getSecondApproverOptions().map(
                                        (approver) => (
                                            <option
                                                key={approver.id}
                                                value={approver.id}
                                            >
                                                {approver.name}
                                            </option>
                                        )
                                    )}
                                </select>
                            </FormField>
                        </div>

                        {/* Purpose */}
                        <FormField label="Purpose" error={errors.purpose}>
                            <textarea
                                className={`textarea textarea-bordered h-24 w-full text-sm md:text-base ${
                                    errors.purpose ? "textarea-error" : ""
                                }`}
                                placeholder="Enter the purpose of booking"
                                value={data.purpose}
                                onChange={(e) =>
                                    setData("purpose", e.target.value)
                                }
                            />
                        </FormField>

                        {/* Submit Button */}
                        <div className="flex flex-col sm:flex-row gap-3 sm:gap-4 mt-6 sm:mt-8">
                            <Link
                                href="/bookings"
                                className="btn btn-secondary w-full sm:w-1/2 text-sm md:text-base"
                            >
                                Back
                            </Link>
                            <button
                                type="submit"
                                className="btn btn-primary w-full sm:w-1/2 text-sm md:text-base"
                                disabled={processing}
                            >
                                {processing ? "Creating..." : "Create Booking"}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
