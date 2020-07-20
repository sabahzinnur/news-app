import axios from 'axios'
import { HTTP_ERROR } from './constants'

const MESSAGE_SERVER_ERROR = 'An error occurred while contacting the server. Below are the technical details.\n'

function isHttpError (statusCode) {
  return statusCode >= 400
}

export async function httpPost (url, data, config) {
  return checkResponse(await axios.post(url, data, config))
}

export async function httpPut (url, data, config) {
  return checkResponse(await axios.put(url, data, config))
}

export async function httpGet (url, config) {
  return checkResponse(await axios.get(url, config))
}

export async function httpDelete (url, config) {
  return checkResponse(await axios.delete(url, config))
}

export async function httpPatch (url, data, config) {
  return checkResponse(await axios.patch(url, data, config))
}

export async function httpOptions (url) {
  return checkResponse(await axios.options(url))
}

class HttpError extends Error {
  constructor (message) {
    super(message)
    this.name = HTTP_ERROR
  }
}

function checkResponse (response) {
  if (isHttpError(response.status)) {
    if (response.data && typeof response.data === 'object') {
      response.data = JSON.stringify(response.data)
    }
    throw new HttpError(`${MESSAGE_SERVER_ERROR} ${response.status}: ${response.data}`)
  }
  return response
}
