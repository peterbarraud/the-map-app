import csv
import random


def get_cat_groups(cats):
    cat_group_list = {}
    with open(r'..\cat-groups.csv', 'r') as csv_file:
        for cat_group in csv.DictReader(csv_file):
            group = cat_group.pop('group', None)
            cat_group_list[group] = [cats[cat] for cat in cat_group.values() if cat != '']
    return cat_group_list


def get_cat_list():
    with open(r'..\cats.csv', 'r') as csv_file:
        return {cat[1]: cat[0] for cat in csv.reader(csv_file)}


def get_phone():
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

def get_address():
    return "Shop No. {}".format(str(random.randint(1,200)))


def main():
    cat_groups = get_cat_groups(get_cat_list())
    areaid = 1
    with open('../../../db.bat/dummy.data.sql', 'w') as dummy_data_file:
        with open(r'..\sample-1.csv', 'r') as csv_file:
            count = 0
            estabs = {row['name'] : cat_groups[row['group']] for row in csv.DictReader(csv_file)}
            for estab, cat_ids in estabs.items():
                count += 1
                est_id = count
                dummy_data_file.write("insert into establishment values({}, '{}', '{}', '{}', {});\n".format(est_id, estab, get_address(), get_phone(), areaid))
                dummy_data_file.write("insert into est_cat (catid, estid) values")
                dummy_data_file.write(", ".join(["(" + cat_id + ", " + str(est_id) + ")" for cat_id in cat_ids]) + ";\n")



if __name__ == '__main__':
    main()
    print("ALL Done!")
