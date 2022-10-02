import React from "react";
import { render } from "react-dom";
import { ReactMultiEmail } from "react-multi-email";
import "react-multi-email/style.css";

const styles = {
    fontFamily: "sans-serif",
    width: "500px",
    border: "1px solid #eee",
    background: "#f3f3f3",
    padding: "25px",
    margin: "20px",
};

export default function MultiEmail({ emails }) {
    return (
        <div style={styles}>
            <h3>react-multi-email</h3>
            <ReactMultiEmail
                placeholder="Input your Email Address"
                emails={emails}
                onChange={(_emails: string[]) => {
                    this.setState({ emails: _emails });
                }}
                getLabel={(
                    email: string,
                    index: number,
                    removeEmail: (index: number) => void
                ) => {
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
            <br />
            <h4>react-multi-email value</h4>
            <p>{emails.join(", ") || "empty"}</p>
        </div>
    );
}
