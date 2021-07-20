import React, { Component } from "react";
import axios from "axios";
import { Icon } from "antd";
import "antd/lib/icon/style/css";
import "../../sass/reset-ant-design.scss";

import { throws } from "assert";

class SearchResult extends Component {
  constructor(props) {
    super(props);
    this.state = {
      data: [],
      start: true,
      errors: false,
      loding: false
    };
  }

  componentDidUpdate = async prevProps => {
    if (this.props.searchValue !== prevProps.searchValue) {
      if (this.props.searchValue.query !== null) {
        this.setState({ loading: true });
        let resp = await this.fetchData();
        console.dir(JSON.stringify(resp));
        if (resp.data) {
          this.setState({
            data: resp.data,
            errors: false,
            loading: false,
            start: false
          });
        } else if (resp.response) {
          this.setState({
            data: [],
            errors: resp.response,
            loading: false,
            start: false
          });
        } else if (resp.request) {
          this.setState({
            data: [],
            errors: true,
            loading: false,
            start: false
          });
        } else {
          this.setState({
            data: [],
            errors: resp.message,
            loading: false,
            start: false
          });
        }
      } else {
        this.setState({
          data: [],
          errors: false,
          loading: false,
          start: false
        });
      }
    }
  };

  fetchData = async () => {
    let apiResp, apiErr;

    apiResp = await axios
      .get(
        `https://nominatim.openstreetmap.org/search?q=${this.props.searchValue.query}&format=json&polygon=1&addressdetails=1&countrycodes=${kpSettings.langCode}`
      )
      .catch(error => {
        apiErr = error;
      });

    if (apiResp !== undefined) return apiResp;
    else return apiErr;
  };

  render() {
    if (this.state.loading === true) {
      return (
        <div>
          <Icon type="loading" />
        </div>
      );
    } else {
      if (this.state.errors === false) {
        if (this.state.data.length > 0) {
          let data = [];

          this.state.data.forEach((item, key) => {
            let found = false;
            /**
             * Eliminate duplicate
             */
            data.forEach(i => {
              if (i.props.children === item.display_name) found = true;
            });

            if (found === false) {
              data.push(
                <a
                  key={key}
                  href={`/?s=${item.display_name}&lng=${item.lon}&lat=${item.lat}&distance=${this.props.searchValue.distance}&post_type=salon`}
                >
                  {item.display_name}
                </a>
              );
            }
          });

          return <div className="searchbox__fast-results mt-3">{data}</div>;
        } else {
          if (this.state.start === true) {
            return null;
          } else {
            return <div>{kpTranslate["no_results"]}</div>;
          }
        }
      } else {
        return (
          <div className="mt-2 alert alert-error">
            {kpTranslate["an_unexpected_error_occurred_please_try_again_soon"]}
          </div>
        );
      }
    }
  }
}

export default SearchResult;
