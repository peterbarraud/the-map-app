import React from 'react';

export const PrimaryResultList = ({primaryestabs}) => {
    return (
        <div className="container">
            <table className="hoverable">
                <caption>Primary RESULTS</caption>
                <thead>
                    <tr>
                    <th>Name</th>
                    <th>Address</th>
                    <th>Phone</th>
                    </tr>
                </thead>
                <tbody>
                    {primaryestabs.items.map(primaryestab => (
                        <tr key={primaryestab.id}>
                            <td data-label="Name">{primaryestab.name}</td>
                            <td data-label="Address">{primaryestab.address}</td>
                            <td data-label="Address">{primaryestab.phone}</td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>            
    )
}