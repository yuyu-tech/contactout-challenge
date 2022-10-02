import React from "react";
import { InertiaLink } from "@inertiajs/inertia-react";
import Layout from "@/Pages/Shared/Layout";

const Dashboard = () => {
    return (
        <div>
            <h1 className="mb-8 text-3xl font-bold">Dashboard</h1>
            <p className="mb-12 leading-normal">
                Hey there! Welcome to Contact Out.
            </p>
        </div>
    );
};

// Persistent layout
// Docs: https://inertiajs.com/pages#persistent-layouts
Dashboard.layout = (page) => <Layout title="Dashboard" children={page} />;

export default Dashboard;
