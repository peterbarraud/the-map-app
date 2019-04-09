import React, {Component} from 'react'
import {ResultList} from './resultlist';
import {NoResults} from './noresults'
import {GetStarted} from './getstarted'
import axios from "axios";
import Select from 'react-select';

// using the class syntax
export class MainForm extends Component {
    state = {
        search : '',
        result : [],
        juststarted : true,
        options: [],
        selectedOption: null,
        restbaseurl: 'http://localhost:8089/services/rest.api.php/',
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
    handleChange = (selectedOption) => {
        this.setState({ selectedOption });
        console.log(`Option selected:`, selectedOption);
      }    

    searchfor = () => {
        this.state.juststarted = false;
        if (this.state.selectedOption === null){
            console.log('no area selected');
        } else {
            if (this.state.search !== ''){
                console.log(this.state.restbaseurl +  "getestabsearchresult/" + this.state.search + "%/" + this.state.selectedOption.value);
                axios
                    .get(this.state.restbaseurl +  "getestabsearchresult/" + this.state.search + "%/" + this.state.selectedOption.value)
                    .then(response => {
                        this.setState({result: response.data.items});
                    });
            }
        }
    }
    checkresults = () => {
        if (this.state.result){
            if (this.state.result.length === 0){
                return false;
            } else{
                return true
            }
        } else{
            return false;
        }
    }
    componentDidMount() {
        let options = []
        axios
        .get(this.state.restbaseurl +  "getallareas")
        .then(response => {
            response.data.items.map(item => (
                options.push({value: item.id, label: item.name})
            ))
            this.setState({options: options})
        });
    }
    render() {
            return (
                <div>
                    <form onSubmit={e => { e.preventDefault(); }}>
                        <Select
                            value={this.state.selectedOption}
                            onChange={this.handleChange}
                            options={this.state.options}
                        />
                        {
                        this.state.selectedOption === null
                            ? <p><mark className="secondary">Select an area to search in.</mark></p>
                            : null
                        }                        
                        <fieldset>
                            <legend>Search</legend>
                            <div className="input-group fluid">
                                <input type="text" id="searcher" placeholder="Search for establishment" onChange={this.searchChange} onKeyUp={this.searchkeyupevent} />
                                <button><span className="icon-search" onClick={this.searchButtonClick}></span></button>
                            </div>
                        </fieldset>
                    </form>
                    {
                        this.state.juststarted === true ? <GetStarted /> : null
                    }
                    {
                        this.checkresults() ? <ResultList results={this.state.result}/> : <NoResults />
                    }                        
                </div>
            )    
        }

}
