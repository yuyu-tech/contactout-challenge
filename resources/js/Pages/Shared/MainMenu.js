import React from "react";
import MainMenuItem from "@/Pages/Shared/MainMenuItem";

export default ({ className }) => {
    return (
        <div className={className}>
            <MainMenuItem text="Dashboard" link="dashboard" icon="dashboard" />
            <MainMenuItem text="Referrals" link="referrals" icon="user-add" />
            {/* <MainMenuItem text="Contacts" link="login" icon="users" />
            <MainMenuItem text="Reports" link="login" icon="printer" /> */}
        </div>
    );
};
