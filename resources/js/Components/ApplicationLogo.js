import React from "react";

export default function ApplicationLogo({ className }) {
    return (
        <span className="text-black	font-bold">
            Concat Out
            <img
                width="50"
                className="inline-block"
                src="/images/logo-square.png"
            />
        </span>
    );
}
