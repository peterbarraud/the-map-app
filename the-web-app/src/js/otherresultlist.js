import React from 'react';

export const OtherResultList = ({relatedestabs}) => {
    return (
        <div className="container">
            <table className="hoverable">
                <caption>Other RESULTS</caption>
                <thead>
                    <tr>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Phone</th>
                    </tr>
                </thead>
                <tbody>
                    {relatedestabs.items.map(relatedestab => (
                        <tr key={relatedestab.id}>
                            <td data-label="Name">{relatedestab.name}</td>
                            <td data-label="Address">{relatedestab.address}</td>
                            <td data-label="Address">{relatedestab.phone}</td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>            
    )
}