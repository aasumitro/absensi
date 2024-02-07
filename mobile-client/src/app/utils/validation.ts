export function hasUpperCase(str: string) {
  return (/[A-Z]/.test(str));
}

export function hasLowerCase(str: string) {
  return (/[a-z]/.test(str));
}

export function hasNumber(str: string) {
  return (/[0-9]/.test(str));
}

export function hasSymbol(str: string) {
  return (/[,.?'"~;:+=-_!@#$%^&*()]/.test(str));
}

export function hasSpace(str: string) {
  return (/[ ]/.test(str));
}

export function validateEmail(email: string) {
  const re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(String(email).toLowerCase());
}

export function isEmpty(param: any) {
  return param === '' ||
    typeof param === 'undefined' ||
    param === 'null' ||
    param === null ||
    param === 'undefined';
}
