import React from 'react';

export const ResultList = ({results}) => {
    return (
        <div className="container">
            <table className="hoverable">
                <caption>RESULTS</caption>
                <thead>
                    <tr>
                    <th>Name</th>
                    <th>Address</th>
                    </tr>
                </thead>
                <tbody>
                    {results.map(item => (
                        <tr key={item}>
                            <td data-label="Name">{item.name}</td>
                            <td data-label="Address">{item.address}</td>
                        </tr>
                    ))}
                </tbody>
            </table>
        </div>            
    )
}