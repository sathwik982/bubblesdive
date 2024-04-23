export const truncate = (str, len) => {
  if (!str || str.length <= len) return str;
  else return str.slice(0, len) + "...";
};
