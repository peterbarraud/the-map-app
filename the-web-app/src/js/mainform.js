import React, {Component} from 'react'
import {ResultList} from './resultlist';
import {NoResults} from './noresults'
import {GetStarted} from './getstarted'
import axios from "axios";

// using the class syntax
export class MainForm extends Component {
    state = {
        search : '',
        result : [],
        juststarted : true
    }
    // mandatory to manage the state of a input element
    searchChange = e => {
        this.setState({search: e.target.value});
    }
    searchkeyupevent = e => {
        if (e.keyCode === 13){
            this.searchfor();
        }
    }
    searchButtonClick = e => {
        this.searchfor();
    }

    searchfor = () => {
        this.state.juststarted = false;
        if (this.state.search !== ''){
            axios
                .get("http://localhost:8089/services/rest.api.php/getestablishmentbyname/" + this.state.search)
                .then(response => {
                    this.setState({result: response.data.items});
                });
        }
    }
    render() {
        if (this.state.juststarted === true){
            return (
                <div>
                    <form onSubmit={e => { e.preventDefault(); }}>
                        <fieldset>
                            <legend>Search</legend>
                            <div className="input-group fluid">
                                <input type="text" id="searcher" placeholder="Search for establishment" onChange={this.searchChange} onKeyUp={this.searchkeyupevent} />
                                <button><span className="icon-search" onClick={this.searchButtonClick}></span></button>
                            </div>
                        </fieldset>
                    </form>
                    <GetStarted />
                </div>
            )    
        } else {
            if (this.state.result.length === 0){
                return (
                    <div>
                        <form onSubmit={e => { e.preventDefault(); }}>
                            <fieldset>
                                <legend>Search</legend>
                                <div className="input-group fluid">
                                    <input type="text" id="searcher" placeholder="Search for establishment" onChange={this.searchChange} onKeyUp={this.searchkeyupevent} />
                                    <button><span className="icon-search" onClick={this.searchButtonClick}></span></button>
                                </div>
                            </fieldset>
                        </form>
                        <NoResults />
                    </div>
                )    
            }
            else {
                return (
                    <div>
                        <form onSubmit={e => { e.preventDefault(); }}>
                            <fieldset>
                                <legend>Search</legend>
                                <div className="input-group fluid">
                                    <input type="text" id="searcher" placeholder="Search for establishment" onChange={this.searchChange} onKeyUp={this.searchkeyupevent} />
                                    <button><span className="icon-search" onClick={this.searchButtonClick}></span></button>
                                </div>
                            </fieldset>
                        </form>
                        <ResultList results={this.state.result}/>
                    </div>
                )
            }
        }
    }
}
