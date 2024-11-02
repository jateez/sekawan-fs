import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { router } from "@inertiajs/react";

export default function Details({ booking, current_user_id }) {
    const firstApproval = booking.approvals.find(
        (approval) => approval.approval_level === "first"
    );
    const secondApproval = booking.approvals.find(
        (approval) => approval.approval_level === "second"
    );

    // Find if the current user is one of the approvers and has a pending approval status
    const userApproval = booking.approvals.find(
        (approval) =>
            approval.approver_id === current_user_id &&
            approval.status === "pending"
    );

    // Check if the first level is approved (needed for the second level approver)
    const isFirstApproved =
        firstApproval && firstApproval.status === "approved";

    return (
        <AuthenticatedLayout>
            <div className="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8 flex justify-center">
                <div className="card bg-base-100 max-w-5xl shadow-xl">
                    <div className="card-body">
                        <h2 className="card-title text-2xl font-semibold mb-4 text-center">
                            Booking Details
                        </h2>

                        <div className="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <p className="font-semibold">Vehicle:</p>
                                <p>
                                    {booking.vehicle?.model || "N/A"} -{" "}
                                    {booking.vehicle?.plate_number || "N/A"}
                                </p>
                            </div>
                            <div>
                                <p className="font-semibold">Location:</p>
                                <p>{booking.location?.name || "N/A"}</p>
                            </div>
                            <div>
                                <p className="font-semibold">Driver:</p>
                                <p>{booking.driver?.name || "N/A"}</p>
                            </div>
                            <div>
                                <p className="font-semibold">Start Date:</p>
                                <p>
                                    {new Date(
                                        booking.start_date
                                    ).toLocaleString()}
                                </p>
                            </div>
                            <div>
                                <p className="font-semibold">End Date:</p>
                                <p>
                                    {new Date(
                                        booking.end_date
                                    ).toLocaleString()}
                                </p>
                            </div>
                            <div>
                                <p className="font-semibold">Status:</p>
                                <p
                                    className={`badge ${
                                        booking.status === "approved"
                                            ? "badge-success"
                                            : booking.status === "rejected"
                                            ? "badge-error"
                                            : "badge-warning"
                                    }`}
                                >
                                    {booking.status}
                                </p>
                            </div>
                            <div>
                                <p className="font-semibold">Purpose:</p>
                                <p>{booking.purpose || "N/A"}</p>
                            </div>

                            {/* Display approvals status */}
                            <div>
                                <p className="font-semibold">
                                    Approval Status:
                                </p>
                                <p>
                                    First Level:{" "}
                                    {firstApproval
                                        ? firstApproval.status === "approved"
                                            ? "Approved"
                                            : "Pending"
                                        : "N/A"}
                                </p>
                                <p>
                                    Second Level:{" "}
                                    {secondApproval
                                        ? secondApproval.status === "approved"
                                            ? "Approved"
                                            : isFirstApproved
                                            ? "Pending"
                                            : "Awaiting First Approval"
                                        : "N/A"}
                                </p>
                            </div>
                        </div>

                        {/* Action buttons */}
                        <div className="card-actions mt-6 flex justify-between">
                            <button
                                className="btn btn-secondary"
                                onClick={() => window.history.back()}
                            >
                                Go Back
                            </button>
                            {userApproval && (
                                <button
                                    className="btn btn-primary"
                                    onClick={() =>
                                        router.post(
                                            route(
                                                "bookings.approve",
                                                booking.id
                                            )
                                        )
                                    }
                                    disabled={
                                        userApproval.approval_level ===
                                            "second" && !isFirstApproved
                                    }
                                >
                                    Approve
                                </button>
                            )}
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
