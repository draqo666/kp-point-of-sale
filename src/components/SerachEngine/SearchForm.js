import React, { Component } from "react";

class SearchForm extends Component {
  componentDidMount = () => {
    this.setState(this.props.searchValue);
  };
  onChangeText = e => {
    this.setState({
      query: e.target.value
    });
  };
  onChangeDistance = e => {
    this.setState({
      distance: e.target.value
    });
  };
  onSubmit = e => {
    e.preventDefault();
    this.props.searchOnChange({
      query: this.state.query,
      distance: this.state.distance
    });
  };
  render() {
    return (
      <form role="search" id="searchform" onSubmit={this.onSubmit}>
        <div className="searchbox">
          <p
            className="mb-4"
            style={{ textTransform: "uppercase", fontWeight: "bold" }}
          >
            {kpTranslate["use_the_search_engine"]}
          </p>
          <div className="searchbox_inner_wrapper">
            <input
              type="text"
              id="searchInput"
              name="searchText"
              placeholder={
                kpTranslate[
                  "enter_any_address_or_city_and_find_a_showroom_nearby"
                ]
              }
              onChange={this.onChangeText}
              defaultValue={
                this.props.searchValue.query.length > 0
                  ? this.props.searchValue.query
                  : ""
              }
            />
            <select name="distance" onChange={this.onChangeDistance}>
              <option
                value="25"
                selected={this.props.searchValue.distance == 25 ? true : false}
              >
                25 km
              </option>
              <option
                value="50"
                selected={this.props.searchValue.distance == 50 ? true : false}
              >
                50 km
              </option>
              <option
                value="100"
                selected={this.props.searchValue.distance == 100 ? true : false}
              >
                100 km
              </option>
            </select>

            <button
              type="submit"
              className="krispol_button krispol_button_orange"
            >
              {kpTranslate["search"]}
            </button>
          </div>
        </div>
      </form>
    );
  }
}

export default SearchForm;
