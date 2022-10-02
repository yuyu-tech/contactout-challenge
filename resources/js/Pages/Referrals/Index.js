import React, { useState } from "react";
import Button from "@/Components/Button";
import { ReactMultiEmail, isEmail } from "react-multi-email";
import { InertiaLink } from "@inertiajs/inertia-react";
import Layout from "@/Pages/Shared/Layout";
import "react-multi-email/style.css";
import { useForm, usePage } from "@inertiajs/inertia-react";
import Pagination from "@/Pages/Shared/Pagination";
import Input from "@/Components/Input";
import Icon from "../Shared/Icon";

const Dashboard = () => {
    const [emails, setEmails] = useState([]);
    const [copyButtonMessageClass, setCopyButtonMessageClass] =
        useState("hidden");

    const { data, setData, post, processing, errors, reset } = useForm({
        emails: [],
    });

    const { referrals, auth, referral_points } = usePage().props;

    /**
     * Submit Referrals
     */
    const submit = (e) => {
        e.preventDefault();

        post(route("referrals.store"));
    };

    /**
     * Copy Code
     */
    const copyCode = () => {
        navigator.clipboard.writeText(auth.referral_link);
        setCopyButtonMessageClass("");
        setTimeout(() => {
            setCopyButtonMessageClass("hidden");
        }, 5000);
    };

    return (
        <div>
            <h1 className="mb-3 text-xl font-bold">Refer A Friend</h1>
            <hr className="mb-3"></hr>
            <p className="mb-3 leading-normal font-bold">
                Get up to 10 Points for referrals.
            </p>
            <p>
                Earn 1 Point for every friend who register on the Contact Out
                and verify their email.
            </p>

            <form className="pt-6 pb-8 mb-4" onSubmit={submit}>
                <div className="mb-4">
                    <label
                        className="block text-gray-700 text-sm font-bold mb-2"
                        htmlFor="username"
                    >
                        Copy your invite link:
                    </label>
                    <div className="flex flex-col items-start">
                        <input
                            value={auth.referral_link}
                            className="mt-1 block w-full pl-4 py-1 text-lg border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                            disabled
                        />
                        <p
                            className={`text-green-500 pt-1 pl-4 text-xs italic ${copyButtonMessageClass}`}
                        >
                            Your link has been copied!
                        </p>
                    </div>
                    <button
                        id="copy-button"
                        onClick={copyCode}
                        className="mt-2 inline-flex items-center px-4 py-2 bg-blue-700 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest active:bg-gray-900 transition ease-in-out duration-150"
                        type="button"
                    >
                        <Icon name="copy" />
                        Copy
                    </button>
                </div>
                <div className="mb-4">
                    <label
                        className="block text-gray-700 text-sm font-bold mb-2"
                        htmlFor="username"
                    >
                        Email your invite:
                    </label>
                    <ReactMultiEmail
                        emails={data.emails}
                        onChange={(_emails) => {
                            setData("emails", _emails);
                        }}
                        validateEmail={(email) => {
                            return isEmail(email); // return boolean
                        }}
                        getLabel={(email, index, removeEmail) => {
                            return (
                                <div data-tag key={index}>
                                    {email}
                                    <span
                                        data-tag-handle
                                        onClick={() => removeEmail(index)}
                                    >
                                        ×
                                    </span>
                                </div>
                            );
                        }}
                    />
                </div>
                <div className="flex items-center justify-between">
                    <Button processing={data.emails.length <= 0 || processing}>
                        Send
                    </Button>
                </div>
            </form>

            <div className="flow-root">
                <p className="float-left mb-3 leading-normal font-bold">
                    Referrals History
                </p>
                <p className="float-right mb-3 leading-normal font-bold">
                    {referral_points} of 10 Points
                </p>
            </div>

            <div>
                <div className="overflow-x-auto bg-white rounded shadow">
                    <table className="w-full whitespace-nowrap">
                        <thead>
                            <tr className="font-bold text-left">
                                <th className="px-6 pt-5 pb-4">
                                    Recipient email
                                </th>
                                <th className="px-6 pt-5 pb-4">Updated</th>
                                <th className="px-6 pt-5 pb-4" colSpan="2">
                                    Status
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            {referrals.data.map(
                                ({ id, email, status, modified_at }) => {
                                    return (
                                        <tr
                                            key={id}
                                            className="hover:bg-gray-100 focus-within:bg-gray-100"
                                        >
                                            <td className="border-t p-3">
                                                {email}
                                            </td>
                                            <td className="border-t p-3">
                                                {modified_at}
                                            </td>
                                            <td className="border-t p-3">
                                                {status}
                                            </td>
                                        </tr>
                                    );
                                }
                            )}
                            {referrals.data.length === 0 && (
                                <tr>
                                    <td
                                        className="px-6 py-4 border-t"
                                        colSpan="4"
                                    >
                                        No Record(s) found.
                                    </td>
                                </tr>
                            )}
                        </tbody>
                    </table>
                </div>
                <Pagination links={referrals.meta.links} />
            </div>
        </div>
    );
};

// Persistent layout
// Docs: https://inertiajs.com/pages#persistent-layouts
Dashboard.layout = (page) => <Layout title="Dashboard" children={page} />;
export default Dashboard;
