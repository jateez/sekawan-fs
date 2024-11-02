import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout";
import { Link, router } from "@inertiajs/react";

export default function Index({ bookings, user_role }) {
    console.log(user_role);
    return (
        <AuthenticatedLayout>
            <div className="flex justify-center items-center px-6 lg:px-24 py-12">
                <div className="min-h-screen w-full">
                    <div className="my-12">
                        {user_role === "admin" ? (
                            <Link
                                href="/bookings/create"
                                className="btn btn-primary"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    strokeWidth={1.5}
                                    stroke="currentColor"
                                    className="size-6"
                                >
                                    <path
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                                    />
                                </svg>
                                Add Booking
                            </Link>
                        ) : (
                            <Link
                                href="/bookings/create"
                                className="btn btn-primary"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    strokeWidth={1.5}
                                    stroke="currentColor"
                                    className="size-6"
                                >
                                    <path
                                        strokeLinecap="round"
                                        strokeLinejoin="round"
                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"
                                    />
                                </svg>
                                Check Approval Request
                            </Link>
                        )}
                    </div>
                    <div className="overflow-x-auto">
                        <table className="table table-zebra table-lg">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Name</th>
                                    <th>Vehicle</th>
                                    <th>Driver</th>
                                    <th>Location</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Status</th>
                                    <th>Purpose</th>
                                    <th>Approved By</th>
                                    <th>Fully Approved</th>
                                </tr>
                            </thead>
                            <tbody>
                                {bookings.map((booking, index) => (
                                    <tr
                                        key={booking.id}
                                        className="hover:bg-gray-50 cursor-pointer"
                                        onClick={() =>
                                            router.visit(
                                                route(
                                                    "bookings.show",
                                                    booking.id
                                                )
                                            )
                                        }
                                    >
                                        <td>{index + 1}</td>
                                        <td>{booking.user_name}</td>
                                        <td>{booking.vehicle_model}</td>
                                        <td>{booking.driver_name}</td>
                                        <td>{booking.location_name}</td>
                                        <td>
                                            {new Date(
                                                booking.start_date
                                            ).toLocaleString()}
                                        </td>
                                        <td>
                                            {new Date(
                                                booking.end_date
                                            ).toLocaleString()}
                                        </td>
                                        <td>{booking.status}</td>
                                        <td>{booking.purpose}</td>
                                        <td>
                                            {booking.approved_by || "Pending"}
                                        </td>
                                        <td>
                                            {booking.is_fully_approved
                                                ? "Yes"
                                                : "No"}
                                        </td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
