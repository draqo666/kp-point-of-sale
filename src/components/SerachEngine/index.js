import React, { Component } from "react";

import SearchForm from "./SearchForm";
import SearchResult from "./SearchResult";

class SearchEngine extends Component {
  constructor(props) {
    super(props);
    let url_string = window.location.href;
    var url = new URL(url_string);

    let distance = url.searchParams.get("distance");
    if (distance === null) distance = 25;

    let query = url.searchParams.get("s");
    if (query === null) query = "";

    this.state = {
      items: null,
      loading: true,
      searchValue: {
        query: query,
        distance: distance
      }
    };
  }

  handleForm = value => {
    this.setState({
      searchValue: value
    });
  };

  render() {
    return (
      <div>
        <SearchForm
          searchOnChange={this.handleForm}
          searchValue={this.state.searchValue}
        />
        <SearchResult searchValue={this.state.searchValue} />
      </div>
    );
  }
}

export default SearchEngine;
