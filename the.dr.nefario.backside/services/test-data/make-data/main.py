import csv
import random


def get_cat_data():
    with open(r'..\cat-list.txt', 'r') as csv_file:
        return {int(x[0]):x[1] for x in csv.reader(csv_file)}


def get_area_data():
    with open(r'..\area-list.txt', 'r') as csv_file:
        return {int(x[0]):x[1] for x in csv.reader(csv_file)}


def get_name_data():
    with open(r'..\name-list.txt', 'r') as csv_file:
        return {int(x[0]):x[1] for x in csv.reader(csv_file)}

def get_cat_ids():
    cat_ids = []
    how_many = 0
    while how_many == 0:
        how_many = random.randint(1, 4)
    if how_many == 1:
        cat_ids.append(random.randint(1, 15))
    else:
        for i in range(1, how_many):
            cat_ids.append(random.randint(1, 15))
    # use set since we want a unique list of cat ids
    if len(cat_ids) == 0:
        print(0)
    return list(set(cat_ids))


def get_estab_phone():
    phone_number = str(random.randint(7,9))
    phone_number += str(random.randint(0,9))
    phone_number += str(random.randint(0,9))
    phone_number += str(random.randint(0,9))
    phone_number += str(random.randint(0,9))
    phone_number += str(random.randint(0,9))
    phone_number += str(random.randint(0,9))
    phone_number += str(random.randint(0,9))
    phone_number += str(random.randint(0,9))
    phone_number += str(random.randint(0,9))
    return phone_number

def get_estab_name(name, cat, area):
    name = "{} [{} - {}]".format(name, cat, area)

    return name

def get_estab_address(area):
    address = area
    return  address


# create a unique number array of 200 names from name-list
def make_name_array():
    name_numbers = []
    next_number = 0
    while len(name_numbers) < random.randint(150, 200):
        next_number += random.randint(1, 10)
        name_numbers.append(next_number)
    return name_numbers


def main():
    cat_data = get_cat_data()
    area_data = get_area_data()
    name_data = get_name_data()

    name_numbers = make_name_array()
    # for each area
    next_est_id = 0
    with open("../dummy.data.sql", 'w') as sql:
        for area_id, _ in area_data.items():
            # create a set of estabs
            for name_number in name_numbers:
                next_est_id += 1
                con_cat = ''
                cat_ids = get_cat_ids()
                for cat_id in cat_ids:
                    con_cat += cat_data[cat_id] + ';'
                sql.write("insert into establishment values({}, '{}', '{}', '{}', {});\n".format(next_est_id, get_estab_name(name_data[name_number], (con_cat.strip()), area_data[area_id]),
                                                                                           get_estab_address(area_data[area_id]),
                                                                                           get_estab_phone(), area_id))
                for cat_id in cat_ids:
                    sql.write("insert into est_cat (`estid`, `catid`) values({}, {});\n".format(next_est_id, cat_id))


if __name__ == '__main__':
    main()
    print("ALL Done!")
