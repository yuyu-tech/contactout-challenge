import React from "react";
import Helmet from "react-helmet";
import MainMenu from "@/Pages/Shared/MainMenu";
import FlashMessages from "@/Pages/Shared/FlashMessages";
import TopHeader from "@/Pages/Shared/TopHeader";
import BottomHeader from "@/Pages/Shared/BottomHeader";

export default function Layout({ title, children }) {
    return (
        <div>
            <Helmet titleTemplate="%s | Contact Out" title={title} />
            <div className="flex flex-col">
                <div className="flex flex-col h-screen">
                    <div className="md:flex">
                        <TopHeader />
                        <BottomHeader />
                    </div>
                    <div className="flex flex-grow overflow-hidden">
                        <MainMenu className="flex-shrink-0 hidden w-56 p-12 overflow-y-auto bg-indigo-800 md:block" />
                        {/* To reset scroll region (https://inertiajs.com/pages#scroll-regions) add `scroll-region="true"` to div below */}
                        <div className="w-full px-4 py-8 overflow-hidden overflow-y-auto md:p-12">
                            <FlashMessages />
                            {children}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}
